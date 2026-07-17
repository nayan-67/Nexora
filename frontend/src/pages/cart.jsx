import { useContext, useEffect, useState } from "react"
import { Link } from "react-router-dom"
import { Minus, Plus, X, ShoppingBag, ArrowRight, Tag, Truck, Lock } from "lucide-react"
import { Button } from "@/components/lightswind/button"
import { toast } from "react-hot-toast";
import { CartContext } from "@/context/CartContext"
import api from "@/lib/api"
const apiBase = api.defaults.baseURL.replace(/\/api\/?$/, "");

function CartItem({ item, prd, variants, cat, onUpdateQuantity, onRemove }) {
  const isVariant = item.prd_type == 2
  const prdDetails = prd?.find((p) => Number(p.id) === Number(item.prd_id))
  const variantDetails = isVariant && variants?.find((v) => v.sku == item.sku)
  const displayData = isVariant ? variantDetails : prdDetails
  const catName = cat?.find((c) => Number(c.id) === Number(prdDetails?.category_id))?.name || "Uncategorized"
  const imageType = isVariant ? 'var' : 'prd'
  const attributes = variantDetails?.attributes

  if (!displayData) {
    return (
      <div className="flex gap-4 border-b border-border/40 py-6 first:pt-0 last:border-0 pt-18.75">
        <div className="h-24 w-24 overflow-hidden rounded-xl bg-muted sm:h-32 sm:w-32 animate-pulse"></div>
        <div className="flex-1">
          <div className="h-4 bg-gray-300 rounded animate-pulse w-3/4"></div>
          <div className="h-4 bg-gray-300 rounded animate-pulse w-1/2 mt-2"></div>
        </div>
      </div>
    )
  }

  return (
    <div key={item.id} className="flex gap-4 border-b border-border/40 py-6 first:pt-0 last:border-0">
      <Link to={`/products/${item.prd_id}`} className="shrink-0">
        <div className="h-24 w-24 overflow-hidden rounded-xl bg-muted sm:h-32 sm:w-32">
          <img
            src={`${apiBase}/uploads/${imageType}_md_${displayData?.featured_image}`}
            alt={prdDetails?.name}
            className="h-full w-full object-cover transition-transform hover:scale-105"
          />
        </div>
      </Link>

      <div className="flex flex-1 flex-col">
        <div className="flex items-start justify-between">
          <div>
            <span className="text-xs text-muted-foreground">{catName}</span>
            <Link
              to={`/products/${item.prd_id}`}
              className="mt-1 block font-medium text-foreground transition-colors hover:text-primary"
            >
              {prdDetails?.name}
            </Link>
            {attributes && (
              <div className="mt-1">
                {attributes.map((val, id) => (
                  <div key={id} className="text-xs text-muted-foreground font-bold">{val.name} :<span className="ps-2 font-medium">{val.value.name || val.value}</span></div>
                ))}
              </div>
            )}
          </div>
          <button
            onClick={() => onRemove(item.id)}
            className="text-muted-foreground transition-colors hover:text-destructive"
          >
            <X className="h-5 w-5" />
          </button>
        </div>

        <div className="mt-auto flex items-end justify-between pt-4">
          <div className="flex items-center rounded-lg border border-input">
            <button
              onClick={() => onUpdateQuantity(item.id, Math.max(1, item.quantity - 1))}
              className="flex h-8 w-8 items-center justify-center text-muted-foreground transition-colors hover:text-foreground"
            >
              <Minus className="h-3.5 w-3.5" />
            </button>
            <span className="w-8 text-center text-sm font-medium text-foreground">{item.quantity}</span>
            <button
              onClick={() => onUpdateQuantity(item.id, Math.min(displayData?.stock, item.quantity + 1))}
              className="flex h-8 w-8 items-center justify-center text-muted-foreground transition-colors hover:text-foreground"
            >
              <Plus className="h-3.5 w-3.5" />
            </button>
          </div>
          <p className="text-lg font-semibold text-foreground">${(displayData?.sale_price ?? displayData?.price) * item.quantity}</p>
        </div>
      </div>
    </div>
  )
}

export default function CartPage() {
  const [couponData, setCouponData] = useState(null)
  const [promoCode, setPromoCode] = useState("")
  const [msg, setmsg] = useState("")
  const [promoApplied, setPromoApplied] = useState(false)
  const [products, setProducts] = useState([])
  const [variants, setVariants] = useState([])
  const [sortCategory, setSortCategory] = useState([])
  const { cartData, setCartData } = useContext(CartContext)

  const checkCoupon = sessionStorage.getItem("coupon")

  useEffect(() => {
    let active = true;

    const loadCatVarData = async () => {
      try {
        const [catResponse, variantResponse, productResponse] = await Promise.all([
          api.get("/sortcategories"),
          api.get("/product/variants"),
          api.get("/products"),
        ])

        if (!active) return

        setSortCategory(catResponse.status === 200 ? catResponse.data : [])
        setVariants(variantResponse.status === 200 ? variantResponse.data : [])
        setProducts(productResponse.status === 200 ? productResponse.data : [])

        if (sessionStorage.getItem("coupon")) {
          setPromoApplied(true)
          const couponData = JSON.parse(sessionStorage.getItem("coupon"))
          setCouponData(couponData)
          setPromoCode(couponData.name)
        }
      } catch (error) {
        if (!active) return

        setSortCategory([])
        setVariants([])
        setProducts([])
        console.error("Error fetching data:", error)
      }
    }

    loadCatVarData()

    return () => {
      active = false;
    };
  }, []);

  const updateQuantity = (id, quantity) => {
    setCartData(items =>
      items.map(item =>
        item.id === id ? { ...item, quantity } : item
      )
    )
    api.post("/card/update", { id, quantity })
      .then((res) => {
        setCartData(res.data.cartdata)
      })
      .catch((err) => {
        console.error("Error updating cart item:", err)
      })
  }

  const removeItem = (id) => {
    setCartData(items => items.filter(item => item.id !== id))
    api.post("/card/remove", { id })
      .then((res) => {
        setCartData(res.data.cartdata)
        toast.success("Item removed from cart");
      })
      .catch((err) => {
        console.error("Error removing cart item:", err)
        toast.error("Failed to remove item from cart");
      })
  }

  const subtotal = cartData.reduce((sum, item) => {
    const isVariant = item.prd_type == 2
    const prdDetails = products?.find((p) => Number(p.id) === Number(item.prd_id))
    const variantDetails = isVariant && variants?.find((v) => v.sku == item.sku)
    const displayData = isVariant ? variantDetails : prdDetails
    return sum + ((displayData?.sale_price || displayData?.price) * item.quantity || 0)
  }, 0)
  const discount = promoApplied ? (couponData.type == 2 ? Number(couponData.amount) : subtotal * (couponData.amount / 100)) : 0
  const shipping = subtotal > 50 ? 0 : 9.99
  const total = subtotal - discount + shipping

  const applyPromoCode = () => {
    api.get(`/applydiscount/${promoCode}`)
      .then((res) => {
        if (res.status == 200) {
          setCouponData(res.data)
          setPromoApplied(true)
          sessionStorage.setItem("coupon", JSON.stringify(res.data));
          setmsg("")
        } else {
          setmsg(res.data.msg)
          toast.error(res.data.msg)
          setPromoApplied(false)
        }
      })
      .catch((err) => {
        console.error(err)
      })
  }
  const removePromoCode = () => {
    sessionStorage.removeItem("coupon")
    setCouponData(null)
    setPromoApplied(false)
    setPromoCode("")
  }

  if (cartData.length === 0) {
    return (
      <div className="flex min-h-screen flex-col bg-background pt-18.75">
        {/* <Header /> */}
        <main className="flex flex-1 items-center justify-center px-4">
          <div className="text-center">
            <div className="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-muted">
              <ShoppingBag className="h-10 w-10 text-muted-foreground" />
            </div>
            <h1 className="mt-6 text-2xl font-bold text-foreground" style={{ fontFamily: 'var(--font-heading)' }}>
              Your cart is empty
            </h1>
            <p className="mt-2 text-muted-foreground">
              Looks like you haven&apos;t added any items to your cart yet.
            </p>
            <Button asChild className="mt-6">
              <Link to="/shop">Start Shopping</Link>
            </Button>
          </div>
        </main>
        {/* <Footer /> */}
      </div>
    )
  }

  return (
    <div className="flex min-h-screen flex-col bg-background pt-18.75">
      {/* <Header /> */}

      <main className="flex-1">
        <div className="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
          <h1 className="text-3xl font-bold tracking-tight text-foreground sm:text-4xl" style={{ fontFamily: 'var(--font-heading)' }}>
            Shopping Cart
          </h1>
          <p className="mt-2 text-muted-foreground">
            {cartData.length} {cartData.length === 1 ? "item" : "items"} in your cart
          </p>

          <div className="mt-8 grid gap-8 lg:grid-cols-3">
            {/* Cart Items */}
            <div className="lg:col-span-2">
              <div className="rounded-2xl border border-border/60 bg-card p-6">
                {cartData && cartData.length > 0 ? (
                  cartData.map((item) => (
                    <CartItem
                      key={item.id || item.sku}
                      item={item}
                      variants={variants}
                      cat={sortCategory}
                      prd={products}
                      onUpdateQuantity={updateQuantity}
                      onRemove={removeItem}
                    />
                  ))
                ) : (
                  <div className="py-8 text-center text-muted-foreground">
                    <p>Loading cart items...</p>
                  </div>
                )}
              </div>

              {/* Continue Shopping */}
              <Link
                to="/shop"
                className="mt-6 inline-flex items-center gap-2 text-sm font-medium text-primary transition-colors hover:text-primary/80"
              >
                <ArrowRight className="h-4 w-4 rotate-180" />
                Continue Shopping
              </Link>
            </div>

            {/* Order Summary */}
            <div className="lg:col-span-1">
              <div className="sticky top-28 rounded-2xl border border-border/60 bg-card p-6">
                <h2 className="text-lg font-semibold text-foreground" style={{ fontFamily: 'var(--font-heading)' }}>
                  Order Summary
                </h2>

                {/* Promo Code */}
                <div className="mt-6">
                  <label className="text-sm font-medium text-foreground">Promo Code</label>
                  <div className="mt-2 flex gap-2">
                    <div className="relative flex-1">
                      <Tag className="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-muted-foreground" />
                      <input
                        type="text"
                        placeholder="Enter code"
                        value={promoCode}
                        onChange={(e) => {
                          setPromoCode(e.target.value)
                          e.target.value == "" ? setmsg("") : ''
                        }}
                        className="h-10 w-full rounded-lg border border-input bg-background pl-10 pr-3 text-sm outline-none focus:ring-1 focus:ring-ring"
                        disabled={promoApplied}
                      />
                    </div>
                    {checkCoupon ? (
                      <Button
                        variant="custom"
                        onClick={removePromoCode}
                        className="h-10 select-none cursor-pointer text-primary border-primary"
                      // disabled={promoApplied || !promoCode}
                      >
                        Remove
                      </Button>
                    ) : (
                      <Button
                        variant="custom"
                        onClick={applyPromoCode}
                        className="h-10 select-none cursor-pointer"
                        disabled={!promoCode}
                      >
                        Apply
                      </Button>
                    )}
                  </div>
                  {promoApplied && (
                    <p className="mt-2 text-sm text-green-600">
                      Promo code applied! You save {couponData.type == 2 ? `$${couponData.amount}` : `${couponData.amount}%`}
                    </p>
                  )}
                  {msg && (
                    <p className="mt-2 text-sm text-red-600">
                      {msg}
                    </p>
                  )}
                  <p className="mt-2 text-xs text-muted-foreground">
                    Try &quot;NEXORA10&quot; for 10% off
                  </p>
                </div>

                {/* Totals */}
                <div className="mt-6 space-y-3 border-t border-border/40 pt-6">
                  <div className="flex justify-between text-sm">
                    <span className="text-muted-foreground">Subtotal</span>
                    <span className="text-foreground">${subtotal.toFixed(2)}</span>
                  </div>
                  {promoApplied && (
                    <div className="flex justify-between text-sm">
                      <span className="text-green-600">Discount ({couponData.type == 2 ? `$${couponData.amount}` : `${couponData.amount}%`})</span>
                      <span className="text-green-600">-${discount.toFixed(2)}</span>
                    </div>
                  )}
                  <div className="flex justify-between text-sm">
                    <span className="text-muted-foreground">Shipping</span>
                    <span className="text-foreground">
                      {shipping === 0 ? "Free" : `$${shipping.toFixed(2)}`}
                    </span>
                  </div>
                  {shipping > 0 && (
                    <p className="text-xs text-muted-foreground">
                      Free shipping on orders over $50
                    </p>
                  )}
                  <div className="flex justify-between border-t border-border/40 pt-3 text-lg font-semibold">
                    <span className="text-foreground">Total</span>
                    <span className="text-foreground">${total.toFixed(2)}</span>
                  </div>
                </div>

                {/* Checkout Button */}
                <Button asChild variant="custom" className="mt-6 h-10 w-full bg-primary text-white font-bold">
                  <Link to="/checkout" className="flex items-center gap-2">
                    Proceed to Checkout
                    <ArrowRight className="h-4 w-4" />
                  </Link>
                </Button>

                {/* Trust Badges */}
                <div className="mt-6 space-y-3 border-t border-border/40 pt-6">
                  <div className="flex items-center gap-2 text-sm text-muted-foreground">
                    <Truck className="h-4 w-4" />
                    Free shipping on orders over $50
                  </div>
                  <div className="flex items-center gap-2 text-sm text-muted-foreground">
                    <Lock className="h-4 w-4" />
                    Secure checkout with SSL encryption
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>

      {/* <Footer /> */}
    </div>
  )
}
