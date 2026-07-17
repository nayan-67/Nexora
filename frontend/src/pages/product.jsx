import { useState, useRef, useEffect, useContext } from "react"
import { Link, useParams } from "react-router-dom"
import { Heart, ShoppingBag, Star, Truck, Shield, RotateCcw, ChevronLeft, Minus, Plus, Check, ZoomIn, LoaderCircle, Share2, Copy, HeartPlus, BellPlus, BellCheck, CopyCheck, CheckCheck } from "lucide-react"
// import { Button } from "@/components/ui/button"
import { Button } from "@/components/lightswind/button"
import { Dialog, DialogTrigger, DialogContent, DialogHeader, DialogTitle, DialogDescription, DialogFooter, DialogClose } from "@/components/lightswind/dialog"
import { Tooltip, TooltipTrigger, TooltipContent } from "@/components/ui/tooltip"
import { cn } from "@/lib/utils"
import api from "@/lib/api"
import { toast } from "react-hot-toast";
import { CartContext } from "../context/CartContext"

const apiBase = api.defaults.baseURL.replace(/\/api\/?$/, "")


function ImageZoom({ src, alt }) {
  const containerRef = useRef(null)
  const [isZoomed, setIsZoomed] = useState(false)
  const [position, setPosition] = useState({ x: 50, y: 50 })

  const handleMouseMove = (e) => {
    if (!containerRef.current) return
    const rect = containerRef.current.getBoundingClientRect()
    const x = ((e.clientX - rect.left) / rect.width) * 100
    const y = ((e.clientY - rect.top) / rect.height) * 100
    setPosition({ x, y })
  }

  return (
    <div
      ref={containerRef}
      className="relative aspect-square cursor-crosshair overflow-hidden rounded-2xl bg-muted"
      onMouseEnter={() => setIsZoomed(true)}
      onMouseLeave={() => setIsZoomed(false)}
      onMouseMove={handleMouseMove}
    >
      <img
        src={src}
        alt={alt}
        className={cn(
          "h-full w-full object-cover transition-transform duration-200",
          isZoomed && "scale-[2.5]"
        )}
        style={isZoomed ? { transformOrigin: `${position.x}% ${position.y}%` } : {}}
      />
      {!isZoomed && (
        <div className="absolute bottom-4 right-4 flex items-center gap-2 rounded-full bg-background/80 px-3 py-1.5 text-xs font-medium text-foreground backdrop-blur-sm">
          <ZoomIn className="h-3.5 w-3.5" />
          Hover to zoom
        </div>
      )}
    </div>
  )
}

function RelatedProductCard({ product, category }) {
  return (
    <Link to={`/products/${product.id}`} className="group flex flex-col">
      <div className="relative aspect-square overflow-hidden rounded-xl bg-muted">
        <img
          src={`${apiBase}/uploads/${product.type == 2 ? 'var' : 'prd'}_md_${product.featured_image}`}
          alt={product.name}
          className="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
        />
      </div>
      <div className="mt-3">
        <span className="text-xs text-muted-foreground">{category}</span>
        <h3 className="mt-1 font-medium text-foreground transition-colors group-hover:text-primary">
          {product.name}
        </h3>
        <p className="mt-1 font-semibold text-foreground">${product.price}</p>
      </div>
    </Link>
  )
}

export default function ProductPage() {
  const params = useParams()
  const [selectedImage, setSelectedImage] = useState(-1)
  const [quantity, setQuantity] = useState(1)
  const [isLiked, setIsLiked] = useState(false)
  const [isNotify, setIsNotify] = useState(false)
  const [addedToCart, setAddedToCart] = useState(false)
  const [product, setProduct] = useState(null)
  const [products, setProducts] = useState(null)
  const [productVariants, setProductVariants] = useState(null)
  const [variantAttr, setVariantAttr] = useState(null)
  const [sortCategory, setSortCategory] = useState([])
  const [selectedAttributes, setSelectedAttributes] = useState({})
  const [isLoading, setIsLoading] = useState(false)
  const [isShareModalOpen, setIsShareModalOpen] = useState(false)
  const [shareLink, setShareLink] = useState("")
  const [copiedShareLink, setCopiedShareLink] = useState(false)
  const hasInitializedVariantRef = useRef(false)

  const { cartData, setCartData } = useContext(CartContext)

  const prdCategory = sortCategory.find(c => Number(c.id) === Number(product?.category_id))
  const variants = product?.type == 2 ? productVariants?.filter(prd => Number(prd.product_id) === Number(product?.id)) : null
  const variantAttributes = product?.type == 2 ? variantAttr?.filter(attr => Number(attr.product_id) === Number(product?.id)) : null

  const getMatchingVariant = () => {
    if (!variants || variants.length === 0) return null
    return variants.find(v => {
      if (!v.attributes || !Array.isArray(v.attributes)) return false

      return Object.entries(selectedAttributes).every(([attrName, selectedValue]) => {
        const variantAttr = v.attributes.find(attr => attr.name === attrName)
        if (!variantAttr) return false

        const variantValue = variantAttr.value
        if (typeof variantValue === 'object' && variantValue !== null) {
          return JSON.stringify(variantValue) === JSON.stringify(selectedValue)
        } else {
          return variantValue === selectedValue
        }
      })
    })
  }

  const canSelectAttributeValue = (attributeName, attributeValue) => {
    if (!variants || variants.length === 0) return true

    const tempSelection = {
      ...selectedAttributes,
      [attributeName]: attributeValue,
    }

    return variants.some(v => {
      if (!v.attributes || !Array.isArray(v.attributes)) return false

      return Object.entries(tempSelection).every(([attrName, selectedValue]) => {
        const variantAttr = v.attributes.find(attr => attr.name === attrName)
        if (!variantAttr) return false

        const variantValue = variantAttr.value
        if (typeof variantValue === 'object' && variantValue !== null) {
          return JSON.stringify(variantValue) === JSON.stringify(selectedValue)
        } else {
          return variantValue === selectedValue
        }
      })
    })
  }

  const selectedVariant = getMatchingVariant()
  const displayPrice = selectedVariant?.price || product?.price
  const displayStock = selectedVariant?.stock || product?.stock
  const displayImage = selectedVariant?.featured_image || product?.featured_image
  const displaySaleBadge = selectedVariant?.sale_price || product?.sale_price
  const sku = selectedVariant?.sku || product?.sku
  let isAddedCart = cartData.find((val) => val.sku === sku ? val.sku === sku : null)

  useEffect(() => {
    let active = true

    const loadProductData = async () => {
      try {
        const [catResponse, productResponse, allProduct, variantResponse, attrResponse] = await Promise.all([
          api.get("/sortcategories"),
          api.get(`/products/${params.id}`),
          api.get("/products"),
          api.get("/product/variants"),
          api.get("/variant-attribute"),
        ])

        if (!active) return
        setSortCategory(catResponse.status === 200 ? catResponse.data : [])
        setProduct(productResponse.status === 200 ? productResponse.data : null)
        setProducts(allProduct.status === 200 ? allProduct.data : null)
        setProductVariants(variantResponse.status === 200 ? variantResponse.data : null)
        setVariantAttr(attrResponse.status === 200 ? attrResponse.data : null)
      } catch (error) {
        if (!active) return

        setSortCategory([])
        setProduct(null)
        setProducts(null)
        setProductVariants(null)
        setVariantAttr(null)
        console.error("Error fetching data:", error)
      }
    }

    loadProductData()
    return () => {
      active = false
    }
  }, [])

  useEffect(() => {
    if (!product) return

    hasInitializedVariantRef.current = false
    setSelectedAttributes({})
    setIsLiked(false)
  }, [product?.id])

  useEffect(() => {
    if (!product) return
    if (typeof window !== "undefined") {
      setShareLink(window.location.href)
    }
  }, [product?.id])

  useEffect(() => {
    if (!isShareModalOpen) return
    setCopiedShareLink(false)
  }, [isShareModalOpen])

  const handleCopyShareLink = async () => {
    if (!shareLink) return
    try {
      await navigator.clipboard.writeText(shareLink)
      setCopiedShareLink(true)
      toast.success("Product URL copied to clipboard")
      setTimeout(() => { setCopiedShareLink(false) }, 2000)
    } catch (error) {
      console.error("Copy failed:", error)
      toast.error("Unable to copy link")
    }
  }

  useEffect(() => {
    if (product?.type != 2 || !productVariants || productVariants.length === 0) return

    const productVariantsList = productVariants.filter(prd => Number(prd.product_id) === Number(product.id))

    if (productVariantsList.length === 0 || hasInitializedVariantRef.current) return

    hasInitializedVariantRef.current = true

    const defaultVariant = productVariantsList[0]
    if (defaultVariant?.attributes && Array.isArray(defaultVariant.attributes)) {
      const autoSelected = {}
      defaultVariant.attributes.forEach(attr => {
        autoSelected[attr.name] = attr.value
      })
      setSelectedAttributes(autoSelected)
    }
  }, [product?.id, product?.type, productVariants])

  useEffect(() => {
    let active = true

    const skuToCheck = product?.type == 2 ? selectedVariant?.sku || null : product?.sku || null

    if (!skuToCheck) {
      setIsLiked(false)
      return () => {
        active = false
      }
    }

    api.get("/wishlist")
      .then((res) => {
        if (!active) return

        const wishlistItems = Array.isArray(res.data) ? res.data : []
        setIsLiked(wishlistItems.some((item) => item.sku === skuToCheck))
      })
      .catch((err) => {
        console.error("Error:", err.response?.data?.message || err.message)
      })

    return () => {
      active = false
    }
  }, [product?.id, product?.type, product?.sku, selectedVariant?.sku])

  if (!product) {
    return (
      <div className="flex min-h-screen flex-col bg-background">
        {/* <Header /> */}
        <main className="flex flex-1 items-center justify-center">
          <div className="text-center">
            <h1 className="text-2xl font-bold text-foreground">Loading ...</h1>
            {/* <p className="mt-2 text-muted-foreground">The product you are looking for does not exist.</p>
            <Button asChild className="mt-4">
              <Link to="/shop">Back to Shop</Link>
            </Button> */}
          </div>
        </main>
        {/* <Footer /> */}
      </div>
    )
  }

  const relatedProducts = products
    .filter(p => p.category_id === product.category_id && p.id !== product.id)
    .slice(0, 4)

  const handleAddToCart = () => {
    let cardData = {
      prdId: product.id,
      prdType: product.type,
      prdSku: selectedVariant?.sku || product.sku,
      quantity: quantity,
    }
    setIsLoading(true)
    setAddedToCart(true)
    api.post("/cart/add", cardData)
      .then((res) => {
        setCartData(res.data.cartdata)
        toast.success("Added to cart");
      })
      .catch((err) => {
        console.error("Error:", err.response?.data?.message || err.message);
        toast.error("Failed to add cart")
      })
      .finally(() => { setIsLoading(false), setTimeout(() => setAddedToCart(false), 2000) })
  }

  const handleAddWish = () => {
    let cardData = {
      prdId: product.id,
      prdType: product.type,
      prdSku: selectedVariant?.sku || product.sku,
    }
    api.post("/wishlist/add", cardData)
      .then((res) => {
        toast.success(res.data.msg);
        setIsLiked(res.data.like)
      })
      .catch((err) => {
        console.error("Error:", err.response?.data?.message || err.message);
        toast.error("Something went wrong!")
      })

  }

  return (
    <div className="flex min-h-screen flex-col bg-background pt-22">
      {/* <Header /> */}

      <main className="flex-1">
        <div className="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
          {/* Breadcrumb */}
          <nav className="mb-8 flex items-center gap-2 text-sm">
            <Link to="/" className="text-muted-foreground transition-colors hover:text-foreground">
              Home
            </Link>
            <span className="text-muted-foreground">/</span>
            <Link to="/shop" className="text-muted-foreground transition-colors hover:text-foreground">
              Shop
            </Link>
            <span className="text-muted-foreground">/</span>
            <Link to={`/category/${prdCategory.slug}`} className="text-muted-foreground transition-colors hover:text-foreground">
              {prdCategory.name}
            </Link>
            <span className="text-muted-foreground">/</span>
            <span className="text-foreground">{product.name}</span>
          </nav>

          {/* Back Link */}
          <Link
            to="/shop"
            className="mb-6 inline-flex items-center gap-2 text-sm text-muted-foreground transition-colors hover:text-foreground"
          >
            <ChevronLeft className="h-4 w-4" />
            Back to Shop
          </Link>

          {/* Product Section */}
          <div className="grid gap-12 lg:grid-cols-2">
            {/* Images */}
            <div className="flex flex-col gap-4 relative">
              {/* Wishlist and Share */}
              <div className="flex flex-col items-center gap-3 absolute top-5 right-5 w-auto h-auto z-48">
                <button
                  onClick={handleAddWish}
                  className={cn(
                    "shrink-0 p-1.5 bg-white rounded-md hover:scale-105 transition-all cursor-pointer",
                    isLiked && "text-destructive"
                  )}
                  title="Wishlist"
                >
                  {isLiked ? (
                    <Heart className={"h-6 w-6 fill-current"} />
                  ) : (
                    <HeartPlus className={"h-6 w-6"} />
                  )}
                </button>
                <Dialog open={isShareModalOpen} onOpenChange={setIsShareModalOpen} className="z-99">
                  <DialogTrigger asChild>
                    <button
                      className={"shrink-0 p-1.5 bg-white hover:scale-105 hover:text-primary transition-all cursor-pointer rounded-md"}
                      title="Share"
                    >
                      <Share2 className={"h-6 w-6"} />
                    </button>
                  </DialogTrigger>
                  <DialogContent className="max-w-md">
                    <DialogHeader>
                      <DialogTitle>Share this product</DialogTitle>
                      <DialogDescription>
                        Copy the current product link and share it with friends.
                      </DialogDescription>
                    </DialogHeader>
                    <div className="mt-6 space-y-4">
                      <div className="relative rounded-xl border border-border bg-muted px-4 py-3">
                        <input
                          type="text"
                          value={shareLink}
                          readOnly
                          className="w-full bg-transparent pr-12 text-sm text-foreground outline-none"
                        />
                        <button
                          type="button"
                          onClick={handleCopyShareLink}
                          className="absolute inset-y-0 right-3 inline-flex items-center justify-center rounded-lg border border-transparent bg-transparent p-2 text-muted-foreground transition hover:text-foreground text-sm"
                          title="Copy link"
                        >
                          {copiedShareLink ? (
                            <CheckCheck className="h-4 w-4 text-green-600" />
                          ) : (
                            <Copy className="h-4 w-4 cursor-pointer" />
                          )}
                        </button>
                      </div>
                    </div>
                  </DialogContent>
                </Dialog>
                {/* <Tooltip>
                  <TooltipTrigger asChild>
                  </TooltipTrigger>
                  <TooltipContent>
                    <p>Share</p>
                  </TooltipContent>
                </Tooltip> */}
              </div>

              <div className="relative">
                {selectedImage == -1 && (
                  <ImageZoom src={`${apiBase}/uploads/${product.type == 2 ? 'var' : 'prd'}_lg_${displayImage}`} alt={product.name} />
                )}
                {selectedImage != -1 && (
                  <ImageZoom src={`${apiBase}/uploads/${product.type == 2 ? (selectedVariant?.gallery_image ? 'var_glr' : 'glr') : 'glr'}_lg_${selectedVariant?.gallery_image?.[selectedImage] ?? product.gallery_image?.[selectedImage] ?? ''}`} alt={product.name} />
                )}
                {product.isNew && (
                  <span className="absolute left-4 top-4 z-10 rounded-full bg-primary px-3 py-1 text-sm font-medium text-primary-foreground">
                    New
                  </span>
                )}
                {product.isBestseller && (
                  <span className="absolute left-4 top-4 z-10 rounded-full bg-foreground px-3 py-1 text-sm font-medium text-background">
                    Bestseller
                  </span>
                )}
              </div>
              <div className="flex gap-3">
                <button
                  key={0}
                  onClick={() => setSelectedImage(-1)}
                  className={cn(
                    "relative aspect-square w-20 overflow-hidden rounded-xl transition-all",
                    selectedImage === -1
                      ? "ring-2 ring-primary ring-offset-2"
                      : "opacity-60 hover:opacity-100"
                  )}
                >
                  <img src={`${apiBase}/uploads/${product.type == 2 ? 'var' : 'prd'}_md_${displayImage}`} alt="" className="h-full w-full object-cover" />
                </button>
                {/* Show variant gallery if selected, otherwise show product gallery */}
                {selectedVariant?.gallery_image && selectedVariant.gallery_image.length > 0 ? (
                  <>
                    {selectedVariant.gallery_image.map((image, index) => (
                      <button
                        key={index}
                        onClick={() => setSelectedImage(index)}
                        className={cn(
                          "relative aspect-square w-20 overflow-hidden rounded-xl transition-all",
                          selectedImage === index
                            ? "ring-2 ring-primary ring-offset-2"
                            : "opacity-60 hover:opacity-100"
                        )}
                      >
                        <img src={`${apiBase}/uploads/var_glr_md_${image}`} alt="" className="h-full w-full object-cover" />
                      </button>
                    ))}
                  </>
                ) : null}
              </div>
            </div>

            {/* Details */}
            <div className="flex flex-col relative">

              <span className="text-sm font-medium text-primary">{prdCategory.name}</span>
              <h1 className="mt-2 text-3xl font-bold tracking-tight text-foreground sm:text-4xl" style={{ fontFamily: 'var(--font-heading)' }}>
                {product.name}
              </h1>

              {/* Rating */}
              <div className="mt-4 flex items-center gap-3">
                <div className="flex items-center gap-1">
                  {[...Array(5)].map((_, i) => (
                    <Star
                      key={i}
                      className={cn(
                        "h-5 w-5",
                        i < Math.floor(4.8)
                          ? "fill-primary text-primary"
                          : "fill-muted text-muted"
                      )}
                    />
                  ))}
                </div>
                <span className="font-medium text-foreground">4.8</span>
                <span className="text-muted-foreground">(9 reviews)</span>
              </div>

              {/* Price */}
              <div className="mt-6 flex items-baseline gap-3">
                {displaySaleBadge && (
                  <>
                    <span className="text-3xl font-bold text-foreground" style={{ fontFamily: 'var(--font-heading)' }}>
                      ${selectedVariant?.sale_price || product.sale_price}
                    </span>
                    <span className="text-xl text-muted-foreground line-through">
                      ${selectedVariant?.price || product.price}
                    </span>
                    <span className="rounded-full bg-destructive/10 px-2.5 py-1 text-sm font-medium text-destructive">
                      Save ${(selectedVariant?.price || product.price) - (selectedVariant?.sale_price || product.sale_price)}
                    </span>
                  </>
                )}
                {!displaySaleBadge && (
                  <span className="text-3xl font-bold text-foreground" style={{ fontFamily: 'var(--font-heading)' }}>
                    ${displayPrice}
                  </span>
                )}
              </div>

              {/* Description */}
              <p className="mt-6 leading-relaxed text-muted-foreground">
                {product.description}
              </p>

              {/* Variants */}
              {product.type == 2 && variantAttributes && variantAttributes.length > 0 && (
                <div className="mt-8 space-y-6">
                  {variantAttributes.map((attr) => {
                    const isColorPicker = attr.display_type === "color_picker"
                    const selectedValue = selectedAttributes[attr.attribute_name]

                    return (
                      <div key={attr.attribute_name}>
                        <div className="flex items-center justify-between">
                          <h3 className="text-sm font-medium text-foreground">
                            {attr.attribute_name}
                          </h3>
                          {selectedValue && attr.display_type == 'color_picker' && (
                            <span className="text-sm text-muted-foreground">
                              {typeof selectedValue === 'object' ? selectedValue.name : selectedValue}
                            </span>
                          )}
                        </div>

                        {/* Color Picker Display */}
                        {isColorPicker ? (
                          <div className="mt-3 flex flex-wrap gap-3">
                            {attr.attribute_values.map((value, index) => {
                              // Value is an object like { code: "#ffffff", name: "White" }
                              const colorCode = value.code || value
                              const colorName = value.name || value
                              const isSelected = selectedValue &&
                                typeof selectedValue === 'object' &&
                                selectedValue.code === colorCode
                              const isDisabled = !canSelectAttributeValue(attr.attribute_name, value)

                              return (
                                <button
                                  key={index}
                                  onClick={() => {
                                    !isDisabled && setSelectedAttributes((prev) => ({
                                      ...prev,
                                      [attr.attribute_name]: value,
                                    })),
                                      setQuantity(1),
                                      setSelectedImage(-1)
                                  }
                                  }
                                  disabled={isDisabled}
                                  className={cn(
                                    "group relative h-10 w-10 rounded-full transition-all",
                                    isDisabled && "cursor-not-allowed opacity-40",
                                    !isDisabled && "cursor-pointer",
                                    isSelected
                                      ? "ring-2 ring-primary ring-offset-2"
                                      : "hover:ring-2 hover:ring-border hover:ring-offset-2"
                                  )}
                                  style={{ backgroundColor: colorCode }}
                                  title={colorName}
                                >
                                  {isSelected && (
                                    <Check
                                      className={cn(
                                        "absolute inset-0 m-auto h-4 w-4",
                                        colorCode === "#ffffff" ||
                                          colorCode === "#c0c0c0" ||
                                          colorCode === "#d2b48c"
                                          ? "text-foreground"
                                          : "text-white"
                                      )}
                                    />
                                  )}
                                  {isDisabled && (
                                    <span className="absolute inset-0 flex items-center justify-center">
                                      <span className={cn("h-px w-full rotate-45", colorCode === "#ffffff" ? "bg-foreground/40" : "bg-white/60")} />
                                    </span>
                                  )}
                                  {colorCode === "#ffffff" && (
                                    <span className="absolute inset-0 rounded-full border border-border" />
                                  )}
                                </button>
                              )
                            })}
                          </div>
                        ) : (
                          /* Normal Button Display */
                          <div className="mt-3 flex flex-wrap gap-2">
                            {attr.attribute_values.map((value, index) => {
                              const isSelected = selectedValue === value
                              const isDisabled = !canSelectAttributeValue(attr.attribute_name, value)

                              return (
                                <button
                                  key={index}
                                  onClick={() => {
                                    !isDisabled && setSelectedAttributes((prev) => ({
                                      ...prev,
                                      [attr.attribute_name]: value,
                                    })),
                                      setQuantity(1),
                                      setSelectedImage(-1)
                                  }
                                  }
                                  // onClick={() => setQuantity(1)}
                                  disabled={isDisabled}
                                  className={cn(
                                    "flex h-10 min-w-10 items-center justify-center rounded-lg border px-3 text-sm font-medium transition-all",
                                    isDisabled && "cursor-not-allowed opacity-40",
                                    !isDisabled && "cursor-pointer",
                                    isSelected
                                      ? "border-primary bg-primary text-primary-foreground"
                                      : "border-border bg-card text-foreground hover:border-primary/50 hover:bg-accent"
                                  )}
                                >
                                  {value}
                                </button>
                              )
                            })}
                          </div>
                        )}
                      </div>
                    )
                  })}
                </div>
              )}

              {/* Features */}
              {product.features && (
                <div className="mt-6">
                  <h3 className="font-medium text-foreground">Features</h3>
                  <ul className="mt-3 grid gap-2 sm:grid-cols-2">
                    {product.features.map((feature, index) => (
                      <li key={index} className="flex items-center gap-2 text-sm text-muted-foreground">
                        <Check className="h-4 w-4 text-primary" />
                        {feature}
                      </li>
                    ))}
                  </ul>
                </div>
              )}

              {/* Stock */}
              <div className="mt-6">
                <span className={cn(
                  "text-sm font-medium",
                  displayStock > 10 ? "text-green-600" : displayStock > 0 ? "text-amber-600" : "text-destructive text-xl"
                )}>
                  {displayStock > 10
                    ? "In Stock"
                    : displayStock > 0
                      ? `Only ${displayStock} left`
                      : "Out of Stock"}
                </span>
                {/* <span className="ml-2 text-sm text-muted-foreground">SKU: {selectedVariant?.sku || product.sku}</span> */}
              </div>

              {/* Quantity */}
              <div className="w-fit flex items-center rounded-xl border border-input mt-5">
                <button
                  onClick={() => setQuantity(Math.max(1, quantity - 1))}
                  className="flex h-10 w-12 items-center justify-center text-muted-foreground transition-colors hover:text-foreground"
                >
                  <Minus className="h-4 w-4" />
                </button>
                <span className="w-12 text-center font-medium text-foreground">{quantity}</span>
                <button
                  onClick={() => setQuantity(Math.min(selectedVariant?.stock || product.stock, quantity + 1))}
                  className="flex h-10 w-12 items-center justify-center text-muted-foreground transition-colors hover:text-foreground"
                  disabled={Number(selectedVariant?.stock || product.stock) === 0}
                >
                  <Plus className="h-4 w-4" />
                </button>
              </div>
              {/* Buy Now & Add to Cart */}
              {displayStock == 0 || (product.type == 2 && variantAttributes && variantAttributes.length > 0 && !selectedVariant) ? (
                <div className="mt-5 flex gap-4 sm:w-fit sm:min-w-[60%]">
                  <Button
                    variant='custom'
                    className="flex-1 items-center gap-2 cursor-pointer select-none w-fit h-12 bg-primary text-white font-bold"
                    onClick={() => setIsNotify(!isNotify)}
                  >
                    {isNotify ? (
                      <>
                        <BellCheck className="h-5 w-5 font-bold" />
                        Notified
                      </>
                    ) : (
                      <>
                        <BellPlus className="h-5 w-5 font-bold" />
                        Notify Me
                      </>
                    )}
                  </Button>
                </div>
              ) : (
                <div className="mt-5 flex gap-4 sm:w-fit sm:min-w-[60%]">
                  {isAddedCart ? (
                    <Button
                      variant='custom'
                      className="flex-1 gap-2 cursor-pointer select-none w-fit h-12 bg-primary text-white font-bold"
                    // onClick={handleAddToCart}
                    // disabled={displayStock == 0 || (product.type == 2 && variantAttributes && variantAttributes.length > 0 && !selectedVariant)}
                    >
                      <Link to={"/cart"} className="flex items-center gap-2" >
                        <ShoppingBag className="h-5 w-5" />
                        Go to Cart
                      </Link>
                    </Button>
                  ) : (
                    <Button
                      variant='custom'
                      className="flex-1 gap-2 cursor-pointer select-none w-fit h-12 bg-primary text-white font-bold"
                      onClick={handleAddToCart}
                      disabled={displayStock == 0 || (product.type == 2 && variantAttributes && variantAttributes.length > 0 && !selectedVariant)}
                    >
                      {addedToCart ? (
                        <>
                          {isLoading ? (
                            <>
                              <LoaderCircle className="animate-spin h-5 w-5" />
                              Add to Cart
                            </>
                          ) : (
                            <>
                              <Check className="h-5 w-5" />
                              Added to Cart
                            </>
                          )}
                        </>
                      ) : (
                        <>
                          <ShoppingBag className="h-5 w-5" />
                          Add to Cart
                        </>
                      )}
                    </Button>
                  )}
                  <Button
                    variant='custom'
                    className="flex-1 gap-2 cursor-pointer select-none h-12 text-primary border-2 border-primary font-bold"
                    // onClick={handleAddToCart}
                    disabled={displayStock == 0 || (product.type == 2 && variantAttributes && variantAttributes.length > 0 && !selectedVariant)}
                  >
                    Buy Now
                  </Button>
                </div>
              )}

              {/* Trust Badges */}
              <div className="mt-8 grid gap-4 rounded-2xl border border-border/60 bg-card p-4 sm:grid-cols-2">
                <div className="flex items-center gap-3">
                  <div className="flex h-10 w-10 items-center justify-center rounded-full bg-primary/10">
                    <Truck className="h-5 w-5 text-primary" />
                  </div>
                  <div>
                    <p className="text-sm font-medium text-foreground">Free Shipping</p>
                    <p className="text-xs text-muted-foreground">On orders over $50</p>
                  </div>
                </div>
                {/* <div className="flex items-center gap-3">
                  <div className="flex h-10 w-10 items-center justify-center rounded-full bg-primary/10">
                    <Shield className="h-5 w-5 text-primary" />
                  </div>
                  <div>
                    <p className="text-sm font-medium text-foreground">2-Year Warranty</p>
                    <p className="text-xs text-muted-foreground">Full coverage</p>
                  </div>
                </div> */}
                <div className="flex items-center gap-3">
                  <div className="flex h-10 w-10 items-center justify-center rounded-full bg-primary/10">
                    <RotateCcw className="h-5 w-5 text-primary" />
                  </div>
                  <div>
                    <p className="text-sm font-medium text-foreground">Easy Returns</p>
                    <p className="text-xs text-muted-foreground">7-day return policy</p>
                  </div>
                </div>
              </div>
            </div>
          </div>

          {/* Related Products */}
          {relatedProducts.length > 0 && (
            <section className="mt-16 border-t border-border/40 pt-16">
              <h2 className="text-2xl font-bold tracking-tight text-foreground" style={{ fontFamily: 'var(--font-heading)' }}>
                You May Also Like
              </h2>
              <div className="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                {relatedProducts.map((product) => (
                  <RelatedProductCard key={product.id} product={product} category={prdCategory.name} />
                ))}
              </div>
            </section>
          )}
        </div>
      </main>
    </div>
  )
}
