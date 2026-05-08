import { useState } from "react"
import { Link } from "react-router-dom"
import { Minus, Plus, X, ShoppingBag, ArrowRight, Tag, Truck, Lock } from "lucide-react"
import { Button } from "@/components/ui/button"

const initialCartItems = [
  {
    id: 1,
    name: "Premium Wireless Headphones",
    price: 299,
    image: "https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=200&h=200&fit=crop&q=80",
    quantity: 1,
    category: "Electronics",
  },
  {
    id: 2,
    name: "Minimalist Watch Collection",
    price: 189,
    image: "https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=200&h=200&fit=crop&q=80",
    quantity: 2,
    category: "Accessories",
  },
  {
    id: 5,
    name: "Leather Crossbody Bag",
    price: 245,
    image: "https://images.unsplash.com/photo-1548036328-c9fa89d128fa?w=200&h=200&fit=crop&q=80",
    quantity: 1,
    category: "Fashion",
  },
]

function CartItem({ item, onUpdateQuantity, onRemove }) {
  return (
    <div className="flex gap-4 border-b border-border/40 py-6 first:pt-0 last:border-0 pt-18.75">
      <Link to={`/products/${item.id}`} className="shrink-0">
        <div className="h-24 w-24 overflow-hidden rounded-xl bg-muted sm:h-32 sm:w-32">
          <img
            src={item.image}
            alt={item.name}
            className="h-full w-full object-cover transition-transform hover:scale-105"
          />
        </div>
      </Link>

      <div className="flex flex-1 flex-col">
        <div className="flex items-start justify-between">
          <div>
            <span className="text-xs text-muted-foreground">{item.category}</span>
            <Link
              to={`/products/${item.id}`}
              className="mt-1 block font-medium text-foreground transition-colors hover:text-primary"
            >
              {item.name}
            </Link>
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
              onClick={() => onUpdateQuantity(item.id, item.quantity + 1)}
              className="flex h-8 w-8 items-center justify-center text-muted-foreground transition-colors hover:text-foreground"
            >
              <Plus className="h-3.5 w-3.5" />
            </button>
          </div>
          <p className="text-lg font-semibold text-foreground">${item.price * item.quantity}</p>
        </div>
      </div>
    </div>
  )
}

export default function CartPage() {
  const [cartItems, setCartItems] = useState(initialCartItems)
  const [promoCode, setPromoCode] = useState("")
  const [promoApplied, setPromoApplied] = useState(false)

  const updateQuantity = (id, quantity) => {
    setCartItems(items =>
      items.map(item =>
        item.id === id ? { ...item, quantity } : item
      )
    )
  }

  const removeItem = (id) => {
    setCartItems(items => items.filter(item => item.id !== id))
  }

  const subtotal = cartItems.reduce((sum, item) => sum + item.price * item.quantity, 0)
  const discount = promoApplied ? subtotal * 0.1 : 0
  const shipping = subtotal > 100 ? 0 : 9.99
  const total = subtotal - discount + shipping

  const applyPromoCode = () => {
    if (promoCode.toLowerCase() === "nexora10") {
      setPromoApplied(true)
    }
  }

  if (cartItems.length === 0) {
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
            {cartItems.length} {cartItems.length === 1 ? "item" : "items"} in your cart
          </p>

          <div className="mt-8 grid gap-8 lg:grid-cols-3">
            {/* Cart Items */}
            <div className="lg:col-span-2">
              <div className="rounded-2xl border border-border/60 bg-card p-6">
                {cartItems.map((item) => (
                  <CartItem
                    key={item.id}
                    item={item}
                    onUpdateQuantity={updateQuantity}
                    onRemove={removeItem}
                  />
                ))}
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
              <div className="sticky top-24 rounded-2xl border border-border/60 bg-card p-6">
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
                        onChange={(e) => setPromoCode(e.target.value)}
                        className="h-10 w-full rounded-lg border border-input bg-background pl-10 pr-3 text-sm outline-none focus:ring-2 focus:ring-ring"
                        disabled={promoApplied}
                      />
                    </div>
                    <Button
                      variant="outline"
                      onClick={applyPromoCode}
                      disabled={promoApplied || !promoCode}
                    >
                      {promoApplied ? "Applied" : "Apply"}
                    </Button>
                  </div>
                  {promoApplied && (
                    <p className="mt-2 text-sm text-green-600">
                      Promo code applied! You save 10%
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
                      <span className="text-green-600">Discount (10%)</span>
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
                      Free shipping on orders over $100
                    </p>
                  )}
                  <div className="flex justify-between border-t border-border/40 pt-3 text-lg font-semibold">
                    <span className="text-foreground">Total</span>
                    <span className="text-foreground">${total.toFixed(2)}</span>
                  </div>
                </div>

                {/* Checkout Button */}
                <Button asChild size="lg" className="mt-6 w-full gap-2">
                  <Link to="/checkout">
                    Proceed to Checkout
                    <ArrowRight className="h-4 w-4" />
                  </Link>
                </Button>

                {/* Trust Badges */}
                <div className="mt-6 space-y-3 border-t border-border/40 pt-6">
                  <div className="flex items-center gap-2 text-sm text-muted-foreground">
                    <Truck className="h-4 w-4" />
                    Free shipping on orders over $100
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
