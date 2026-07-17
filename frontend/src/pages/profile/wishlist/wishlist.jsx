import { useEffect, useState } from "react"
import { Heart, ShoppingBag, Trash2, Filter, LayoutGrid, List as ListIcon } from "lucide-react"
import { Button } from "@/components/ui/button"
import { cn } from "@/lib/utils"
import { Link } from "react-router-dom"
import { toast } from "react-hot-toast"
import api from "@/lib/api"
const apiBase = api.defaults.baseURL.replace(/\/api\/?$/, "")


const initialWishlistItems = [
  {
    id: 1,
    name: "Premium Wireless Headphones",
    price: 299,
    originalPrice: 349,
    image: "https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=400&h=400&fit=crop&q=80",
    category: "Electronics",
    rating: 4.9,
    reviews: 128,
    inStock: true,
    addedDate: "2024-01-15",
  },
  {
    id: 2,
    name: "Classic Leather Watch",
    price: 199,
    originalPrice: 249,
    image: "https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=400&h=400&fit=crop&q=80",
    category: "Accessories",
    rating: 4.8,
    reviews: 64,
    inStock: true,
    addedDate: "2024-01-10",
  },
  {
    id: 3,
    name: "Premium Sunglasses",
    price: 149,
    originalPrice: 199,
    image: "https://images.unsplash.com/photo-1572635196237-14b3f281503f?w=400&h=400&fit=crop&q=80",
    category: "Accessories",
    rating: 4.7,
    reviews: 92,
    inStock: true,
    addedDate: "2024-01-08",
  },
  {
    id: 4,
    name: "Luxury Leather Bag",
    price: 399,
    originalPrice: 499,
    image: "https://images.unsplash.com/photo-1548036328-c9fa89d128fa?w=400&h=400&fit=crop&q=80",
    category: "Fashion",
    rating: 4.9,
    reviews: 156,
    inStock: false,
    addedDate: "2024-01-05",
  },
  {
    id: 5,
    name: "Organic Cotton T-Shirt",
    price: 59,
    originalPrice: 79,
    image: "https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=400&h=400&fit=crop&q=80",
    category: "Fashion",
    rating: 4.6,
    reviews: 48,
    inStock: true,
    addedDate: "2024-01-03",
  },
  {
    id: 6,
    name: "Cashmere Scarf",
    price: 189,
    originalPrice: 249,
    image: "https://images.unsplash.com/photo-1518391846015-55a9cc003b25?w=400&h=400&fit=crop&q=80",
    category: "Fashion",
    rating: 4.8,
    reviews: 73,
    inStock: true,
    addedDate: "2024-01-01",
  },
  {
    id: 7,
    name: "Classic Canvas Sneakers",
    price: 89,
    originalPrice: 119,
    image: "https://images.unsplash.com/photo-1525966222134-fcfa99b8ae77?w=400&h=400&fit=crop&q=80",
    category: "Fashion",
    rating: 4.5,
    reviews: 234,
    inStock: true,
    addedDate: "2023-12-30",
  },
  {
    id: 8,
    name: "Designer Sunglasses Pro",
    price: 279,
    originalPrice: 349,
    image: "https://images.unsplash.com/photo-1509695307050-d4066910ec1e?w=400&h=400&fit=crop&q=80",
    category: "Accessories",
    rating: 4.9,
    reviews: 89,
    inStock: true,
    addedDate: "2023-12-28",
  },
]

export default function WishlistPage() {
  const [wishlistItems, setWishlistItems] = useState([])
  const [viewMode, setViewMode] = useState("grid")
  const [sortBy, setSortBy] = useState("recent")
  const [filterCategory, setFilterCategory] = useState("all")
  const [products, setProducts] = useState([])
  const [productVariants, setProductVariants] = useState(null)
  const [sortCategory, setSortCategory] = useState([])
  const [isLoading, setIsLoading] = useState(false)

  useEffect(() => {
    let active = true
    setIsLoading(true)
    const loadWishData = async () => {
      try {
        const [catResponse, productResponse, variantResponse, wishResponce] = await Promise.all([
          api.get("/sortcategories"),
          api.get("/products"),
          api.get("/product/variants"),
          api.get("/wishlist")
        ])

        if (!active) return

        setSortCategory(catResponse.status === 200 ? catResponse.data : [])
        setProducts(productResponse.status === 200 ? productResponse.data : [])
        setProductVariants(variantResponse.status === 200 ? variantResponse.data : null)
        setWishlistItems(wishResponce.status === 200 ? wishResponce.data : [])
      } catch (error) {
        if (!active) return

        setSortCategory([])
        setProducts([])
        setWishlistItems([])
        console.error("Error fetching data:", error)
      }
    }

    loadWishData()

    return () => {
      active = false
    }
  }, [])

  // const categories = ["all", "Electronics", "Fashion", "Accessories"]

  const filteredItems = wishlistItems.filter(item => {
    const productItem = products.find(val => Number(item.prd_id) === Number(val.id))
    const catName = sortCategory.find(cat => Number(cat.id) == Number(productItem.category_id))?.name
    return (
      filterCategory === "all" ? true : catName === filterCategory
    )
  }
  )

  // const filterProducts = filteredItems.map((item) => {
  //   const productItem = products.find(val => Number(item.prd_id) === Number(val.id))
  //   const prdData = productItem.type == 2 ? productVariants.find(varItem => varItem.sku == item.sku) : productItem
  // })

  const sortedItems = [...filteredItems].sort((a, b) => {
    // const productItem = products.find(val => Number(item.prd_id) === Number(val.id))
    // const prdData = productItem.type == 2 ? productVariants.find(varItem => varItem.sku == item.sku) : productItem
    if (sortBy === "recent") {
      return new Date(b.addedDate) - new Date(a.addedDate)
    } else if (sortBy === "price-low") {
      return a.price - b.price
    } else if (sortBy === "price-high") {
      return b.price - a.price
    } else if (sortBy === "rating") {
      return b.rating - a.rating
    }
    return 0
  })

  const handleRemoveFromWishlist = (sku) => {
    setWishlistItems(wishlistItems.filter(item => item.sku !== sku))
  }

  const handleMoveToCart = (id) => {
    // Add to cart logic here
    handleRemoveFromWishlist(id)
  }

  return (
    <div className="flex min-h-screen flex-col bg-background">
      {/* <Header /> */}

      <main className="flex-1">
        <div className="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8 pt-32">
          {/* Page Header */}
          <div className="mb-8">
            <h1 className="text-3xl font-bold tracking-tight text-foreground" style={{ fontFamily: 'var(--font-heading)' }}>
              My Wishlist
            </h1>
            <p className="mt-2 text-muted-foreground">
              You have {wishlistItems.length} items in your wishlist
            </p>
          </div>

          {wishlistItems.length > 0 ? (
            <>
              {/* Controls */}
              <div className="mb-6 flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
                <div className="flex items-center gap-2">
                  <Filter className="h-5 w-5 text-muted-foreground" />
                  <select
                    value={filterCategory}
                    onChange={(e) => setFilterCategory(e.target.value)}
                    className="rounded-lg border border-input bg-background px-3 py-2 text-sm outline-none transition-colors focus:border-primary focus:ring-2 focus:ring-ring"
                  >
                    <option value="all">All Categories</option>
                    {sortCategory.map(cat => (
                      <option key={cat.id} value={cat.name}>
                        {cat.name}
                      </option>
                    ))}
                  </select>
                  <select
                    value={sortBy}
                    onChange={(e) => setSortBy(e.target.value)}
                    className="rounded-lg border border-input bg-background px-3 py-2 text-sm outline-none transition-colors focus:border-primary focus:ring-2 focus:ring-ring"
                  >
                    <option value="recent">Recently Added</option>
                    <option value="price-low">Price: Low to High</option>
                    <option value="price-high">Price: High to Low</option>
                    <option value="rating">Highest Rated</option>
                  </select>
                </div>

                <div className="flex items-center gap-2 border border-border/60 rounded-lg p-1">
                  <button
                    onClick={() => setViewMode("grid")}
                    className={cn(
                      "rounded px-3 py-1.5 transition-colors",
                      viewMode === "grid"
                        ? "bg-primary text-primary-foreground"
                        : "text-muted-foreground hover:text-foreground"
                    )}
                  >
                    <LayoutGrid className="h-4 w-4" />
                  </button>
                  <button
                    onClick={() => setViewMode("list")}
                    className={cn(
                      "rounded px-3 py-1.5 transition-colors",
                      viewMode === "list"
                        ? "bg-primary text-primary-foreground"
                        : "text-muted-foreground hover:text-foreground"
                    )}
                  >
                    <ListIcon className="h-4 w-4" />
                  </button>
                </div>
              </div>

              {/* Items */}
              {viewMode === "grid" ? (
                <div className="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                  {sortedItems.map((item) => {
                    const productItem = products.find(val => Number(item.prd_id) === Number(val.id))
                    const prdData = productItem.type == 2 ? productVariants.find(varItem => varItem.sku == item.sku) : productItem
                    const catName = sortCategory.find(cat => Number(cat.id) == Number(productItem.category_id))?.name
                    return (
                      <div
                        key={item.id}
                        className="group overflow-hidden rounded-xl border border-border/60 bg-card transition-all hover:border-primary/30 hover:shadow-sm"
                      >
                        {/* Image */}
                        <div className="relative overflow-hidden bg-muted">
                          <img
                            src={`${apiBase}/uploads/${productItem.type == 2 ? 'var' : 'prd'}_md_${prdData.featured_image}`}
                            alt={productItem.name}
                            className="h-40 w-full object-cover transition-transform group-hover:scale-105"
                          />
                          <button
                            // onClick={() => handleRemoveFromWishlist(item.id)}
                            className="absolute right-2 top-2 flex h-8 w-8 items-center justify-center rounded-full bg-white/80 text-red-500 backdrop-blur-sm transition-all hover:bg-white hover:scale-110"
                          >
                            <Heart className="h-4 w-4 fill-current" />
                          </button>
                          {!prdData.stock && (
                            <div className="absolute inset-0 flex items-center justify-center bg-black/40 backdrop-blur-sm">
                              <span className="text-sm font-medium text-white">Out of Stock</span>
                            </div>
                          )}
                        </div>

                        {/* Content */}
                        <div className="p-4">
                          <p className="text-xs text-muted-foreground">{catName}</p>
                          <Link to={`/products/${productItem.id}`}>
                            <h3 className="mt-1 line-clamp-2 font-semibold text-foreground transition-colors hover:text-primary">
                              {productItem.name}
                            </h3>
                          </Link>

                          <div className="mt-3 flex items-center gap-1 text-sm">
                            <span className="text-yellow-500">★</span>
                            <span className="font-medium text-foreground">4.8</span>
                            <span className="text-muted-foreground">(9)</span>
                          </div>

                          <div className="mt-3 flex items-end gap-2">
                            <div>
                              <p className="text-lg font-bold text-foreground">${prdData.sale_price || prdData.price}</p>
                              {prdData.sale_price && (
                                <p className="text-xs text-muted-foreground line-through">
                                  ${prdData.price}
                                </p>
                              )}
                            </div>
                          </div>

                          <Button
                            // onClick={() => handleMoveToCart(item.id)}
                            disabled={!prdData.stock}
                            className="mt-4 w-full gap-2"
                            size="sm"
                          >
                            <ShoppingBag className="h-4 w-4" />
                            Move to Cart
                          </Button>
                        </div>
                      </div>
                    )
                  })}
                </div>
              ) : (
                <div className="space-y-3">
                  {sortedItems.map((item) => {
                    const productItem = products.find(val => Number(item.prd_id) === Number(val.id))
                    const prdData = productItem.type == 2 ? productVariants.find(varItem => varItem.sku == item.sku) : productItem
                    const catName = sortCategory.find(cat => Number(cat.id) == Number(productItem.category_id))?.name
                    return (
                      <div
                        key={item.id}
                        className="flex gap-4 rounded-xl border border-border/60 bg-card p-4 transition-all hover:border-primary/30 hover:shadow-sm"
                      >
                        {/* Image */}
                        <div className="relative h-32 w-32 shrink-0 overflow-hidden rounded-lg bg-muted">
                          <img
                            src={`${apiBase}/uploads/${productItem.type == 2 ? 'var' : 'prd'}_md_${prdData.featured_image}`}
                            alt={productItem.name}
                            className="h-full w-full object-cover"
                          />
                          {!prdData.stock && (
                            <div className="absolute inset-0 flex items-center justify-center bg-black/40 backdrop-blur-sm">
                              <span className="text-xs font-medium text-white">Out of Stock</span>
                            </div>
                          )}
                        </div>

                        {/* Content */}
                        <div className="flex flex-1 flex-col justify-between">
                          <div>
                            <p className="text-xs text-muted-foreground">{catName}</p>
                            <Link to={`/products/${productItem.id}`}>
                              <h3 className="mt-1 font-semibold text-foreground transition-colors hover:text-primary">
                                {productItem.name}
                              </h3>
                            </Link>
                            <div className="mt-2 flex items-center gap-1 text-sm">
                              <span className="text-yellow-500">★</span>
                              <span className="font-medium text-foreground">4.8</span>
                              <span className="text-muted-foreground">(9)</span>
                            </div>
                          </div>
                          <div className="mt-3 flex items-center justify-between">
                            <div>
                              <p className="font-bold text-foreground">${prdData.sale_price || prdData.price}</p>
                              {prdData.sale_price && (
                                <p className="text-xs text-muted-foreground line-through">
                                  ${prdData.price}
                                </p>
                              )}
                            </div>
                          </div>
                        </div>

                        {/* Actions */}
                        <div className="flex flex-col justify-between gap-2">
                          <Button
                            // onClick={() => handleMoveToCart(item.id)}
                            disabled={!prdData.stock}
                            className="gap-2"
                            size="sm"
                          >
                            <ShoppingBag className="h-4 w-4" />
                          </Button>
                          <Button
                            // onClick={() => handleRemoveFromWishlist(prdData.sku)}
                            variant="outline"
                            size="sm"
                            className="text-destructive hover:bg-destructive/10"
                          >
                            <Trash2 className="h-4 w-4" />
                          </Button>
                        </div>
                      </div>
                    )
                  })}
                </div>
              )}
            </>
          ) : (
            <div className="rounded-2xl border-2 border-dashed border-border/60 bg-card/40 py-16 text-center">
              <Heart className="mx-auto h-12 w-12 text-muted-foreground/30" />
              <h3 className="mt-4 text-lg font-semibold text-foreground" style={{ fontFamily: 'var(--font-heading)' }}>
                Your wishlist is empty
              </h3>
              <p className="mt-2 text-muted-foreground">
                Add items to your wishlist to save them for later
              </p>
              <Button asChild className="mt-6">
                <Link to="/shop">Continue Shopping</Link>
              </Button>
            </div>
          )}
        </div>
      </main>

      {/* <Footer /> */}
    </div>
  )
}
