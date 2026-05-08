import { useState, useMemo } from "react"
import { Link } from "react-router-dom"
import { Heart, ShoppingBag, Star, SlidersHorizontal, Grid3X3, LayoutGrid, ChevronDown, X } from "lucide-react"
import { Button } from "@/components/ui/button"
import { cn } from "@/lib/utils"
import { products, categories } from "@/lib/products"

const sortOptions = [
  { label: "Featured", value: "featured" },
  { label: "Newest", value: "newest" },
  { label: "Price: Low to High", value: "price-asc" },
  { label: "Price: High to Low", value: "price-desc" },
  { label: "Best Rating", value: "rating" },
]

const priceRanges = [
  { label: "All Prices", min: 0, max: Infinity },
  { label: "Under $50", min: 0, max: 50 },
  { label: "$50 - $100", min: 50, max: 100 },
  { label: "$100 - $200", min: 100, max: 200 },
  { label: "$200+", min: 200, max: Infinity },
]

function ProductCard({ product }) {
  const [isLiked, setIsLiked] = useState(false)

  return (
    <div className="group relative flex flex-col">
      <div className="relative aspect-square overflow-hidden rounded-2xl bg-muted">
        <Link to={`/products/${product.id}`} >
          <img
            src={product.image}
            alt={product.name}
            className="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
          />
        </Link>

        <div className="absolute left-3 top-3 flex flex-col gap-2">
          {product.isNew && (
            <span className="rounded-full bg-primary px-2.5 py-1 text-xs font-medium text-primary-foreground">
              New
            </span>
          )}
          {product.isBestseller && (
            <span className="rounded-full bg-foreground px-2.5 py-1 text-xs font-medium text-background">
              Bestseller
            </span>
          )}
          {product.originalPrice && (
            <span className="rounded-full bg-destructive px-2.5 py-1 text-xs font-medium text-white">
              Sale
            </span>
          )}
        </div>

        <div className="absolute right-3 top-3 flex flex-col gap-2 opacity-0 transition-opacity group-hover:opacity-100">
          <button
            onClick={() => setIsLiked(!isLiked)}
            className={cn(
              "flex h-9 w-9 items-center justify-center rounded-full bg-card/90 shadow-sm backdrop-blur-sm transition-colors",
              isLiked ? "text-destructive" : "text-muted-foreground hover:text-foreground"
            )}
          >
            <Heart className={cn("h-4 w-4 cursor-pointer", isLiked && "fill-current")} />
          </button>
        </div>

        <div className="absolute inset-x-3 bottom-3 translate-y-2 opacity-0 transition-all group-hover:translate-y-0 group-hover:opacity-100">
          <Button className="w-full gap-2 shadow-lg cursor-pointer" size="sm">
            <ShoppingBag className="h-4 w-4" />
            Add to Cart
          </Button>
        </div>
      </div>

      <div className="mt-4 flex flex-col">
        <span className="text-xs font-medium text-muted-foreground">{product.category}</span>
        <Link to={`/products/${product.id}`} className="mt-1 font-medium text-foreground transition-colors hover:text-primary">
          {product.name}
        </Link>
        <div className="mt-2 flex items-center gap-2">
          <div className="flex items-center gap-1">
            <Star className="h-3.5 w-3.5 fill-primary text-primary" />
            <span className="text-sm font-medium text-foreground">{product.rating}</span>
          </div>
          <span className="text-sm text-muted-foreground">({product.reviews})</span>
        </div>
        <div className="mt-2 flex items-center gap-2">
          <span className="text-lg font-semibold text-foreground">${product.price}</span>
          {product.originalPrice && (
            <span className="text-sm text-muted-foreground line-through">${product.originalPrice}</span>
          )}
        </div>
      </div>
    </div>
  )
}

export default function ShopPage() {
  const [selectedCategory, setSelectedCategory] = useState("All")
  const [selectedSort, setSelectedSort] = useState("featured")
  const [selectedPriceRange, setSelectedPriceRange] = useState(0)
  const [gridCols, setGridCols] = useState(4)
  const [showFilters, setShowFilters] = useState(false)

  const filteredProducts = useMemo(() => {
    let filtered = [...products]

    // Category filter
    if (selectedCategory !== "All") {
      filtered = filtered.filter(p => p.category === selectedCategory)
    }

    // Price filter
    const priceRange = priceRanges[selectedPriceRange]
    filtered = filtered.filter(p => p.price >= priceRange.min && p.price < priceRange.max)

    // Sort
    switch (selectedSort) {
      case "newest":
        filtered = filtered.filter(p => p.isNew).concat(filtered.filter(p => !p.isNew))
        break
      case "price-asc":
        filtered.sort((a, b) => a.price - b.price)
        break
      case "price-desc":
        filtered.sort((a, b) => b.price - a.price)
        break
      case "rating":
        filtered.sort((a, b) => b.rating - a.rating)
        break
      default:
        break
    }

    return filtered
  }, [selectedCategory, selectedSort, selectedPriceRange])

  return (
    <div className="flex min-h-screen flex-col bg-background">
      {/*  <Header /> */}

      <main className="flex-1">
        {/* Hero Banner */}
        <div className="relative overflow-hidden bg-linear-to-br from-primary/10 via-background to-accent/20 pt-18.75">
          <div className="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
            <div className="text-center">
              <h1 className="text-4xl font-bold tracking-tight text-foreground sm:text-5xl" style={{ fontFamily: 'var(--font-heading)' }}>
                Shop All Products
              </h1>
              <p className="mx-auto mt-4 max-w-2xl text-lg text-muted-foreground">
                Discover our curated collection of premium products
              </p>
            </div>
          </div>
          <div className="absolute -right-20 -top-20 h-64 w-64 rounded-full bg-primary/5 blur-3xl" />
          <div className="absolute -bottom-20 -left-20 h-64 w-64 rounded-full bg-accent/10 blur-3xl" />
        </div>

        <div className="mx-auto max-w-7xl pt-4 py-8 sm:px-6 lg:px-8 pb-10">
          {/* Toolbar */}
          <div className="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div className="flex items-center gap-2">
              <Button
                variant="outline"
                size="sm"
                onClick={() => setShowFilters(!showFilters)}
                className="gap-2"
              >
                <SlidersHorizontal className="h-4 w-4" />
                Filters
              </Button>
              <span className="text-sm text-muted-foreground">
                {filteredProducts.length} products
              </span>
            </div>

            <div className="flex items-center gap-4">
              {/* Sort Dropdown */}
              <div className="relative">
                <select
                  value={selectedSort}
                  onChange={(e) => setSelectedSort(e.target.value)}
                  className="h-9 appearance-none rounded-lg border border-input bg-background px-3 pr-8 text-sm outline-none focus:ring-2 focus:ring-ring"
                >
                  {sortOptions.map((option) => (
                    <option key={option.value} value={option.value}>
                      {option.label}
                    </option>
                  ))}
                </select>
                <ChevronDown className="pointer-events-none absolute right-2 top-1/2 h-4 w-4 -translate-y-1/2 text-muted-foreground" />
              </div>

              {/* Grid Toggle */}
              <div className="hidden items-center gap-1 rounded-lg border border-input p-1 sm:flex">
                <button
                  onClick={() => setGridCols(3)}
                  className={cn(
                    "rounded-md p-1.5 transition-colors",
                    gridCols === 3 ? "bg-accent text-foreground" : "text-muted-foreground hover:text-foreground"
                  )}
                >
                  <Grid3X3 className="h-4 w-4" />
                </button>
                <button
                  onClick={() => setGridCols(4)}
                  className={cn(
                    "rounded-md p-1.5 transition-colors",
                    gridCols === 4 ? "bg-accent text-foreground" : "text-muted-foreground hover:text-foreground"
                  )}
                >
                  <LayoutGrid className="h-4 w-4" />
                </button>
              </div>
            </div>
          </div>

          {/* Filters Panel */}
          {showFilters && (
            <div className="mb-8 rounded-2xl border border-border/60 bg-card p-6">
              <div className="flex items-center justify-between">
                <h3 className="font-semibold text-foreground">Filters</h3>
                <button
                  onClick={() => setShowFilters(false)}
                  className="text-muted-foreground hover:text-foreground"
                >
                  <X className="h-5 w-5" />
                </button>
              </div>

              <div className="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                {/* Categories */}
                <div>
                  <h4 className="mb-3 text-sm font-medium text-foreground">Category</h4>
                  <div className="flex flex-wrap gap-2">
                    {categories.map((category) => (
                      <button
                        key={category}
                        onClick={() => setSelectedCategory(category)}
                        className={cn(
                          "rounded-full px-3 py-1.5 text-sm font-medium transition-all",
                          selectedCategory === category
                            ? "bg-primary text-primary-foreground"
                            : "bg-accent text-accent-foreground hover:bg-accent/80"
                        )}
                      >
                        {category}
                      </button>
                    ))}
                  </div>
                </div>

                {/* Price Range */}
                <div>
                  <h4 className="mb-3 text-sm font-medium text-foreground">Price Range</h4>
                  <div className="flex flex-wrap gap-2">
                    {priceRanges.map((range, index) => (
                      <button
                        key={range.label}
                        onClick={() => setSelectedPriceRange(index)}
                        className={cn(
                          "rounded-full px-3 py-1.5 text-sm font-medium transition-all",
                          selectedPriceRange === index
                            ? "bg-primary text-primary-foreground"
                            : "bg-accent text-accent-foreground hover:bg-accent/80"
                        )}
                      >
                        {range.label}
                      </button>
                    ))}
                  </div>
                </div>

                {/* Clear Filters */}
                <div className="flex items-end">
                  <Button
                    variant="ghost"
                    size="sm"
                    onClick={() => {
                      setSelectedCategory("All")
                      setSelectedPriceRange(0)
                      setSelectedSort("featured")
                    }}
                  >
                    Clear All Filters
                  </Button>
                </div>
              </div>
            </div>
          )}

          {/* Active Filters */}
          {(selectedCategory !== "All" || selectedPriceRange !== 0) && (
            <div className="mb-6 flex flex-wrap items-center gap-2">
              <span className="text-sm text-muted-foreground">Active filters:</span>
              {selectedCategory !== "All" && (
                <button
                  onClick={() => setSelectedCategory("All")}
                  className="inline-flex items-center gap-1 rounded-full bg-primary/10 px-3 py-1 text-sm font-medium text-primary"
                >
                  {selectedCategory}
                  <X className="h-3 w-3" />
                </button>
              )}
              {selectedPriceRange !== 0 && (
                <button
                  onClick={() => setSelectedPriceRange(0)}
                  className="inline-flex items-center gap-1 rounded-full bg-primary/10 px-3 py-1 text-sm font-medium text-primary"
                >
                  {priceRanges[selectedPriceRange].label}
                  <X className="h-3 w-3" />
                </button>
              )}
            </div>
          )}

          {/* Products Grid */}
          {filteredProducts.length > 0 ? (
            <div className={cn(
              "grid gap-6",
              gridCols === 3 ? "sm:grid-cols-2 lg:grid-cols-3" : "sm:grid-cols-2 lg:grid-cols-4"
            )}>
              {filteredProducts.map((product) => (
                <ProductCard key={product.id} product={product} />
              ))}
            </div>
          ) : (
            <div className="flex flex-col items-center justify-center py-16">
              <div className="rounded-full bg-muted p-4">
                <ShoppingBag className="h-8 w-8 text-muted-foreground" />
              </div>
              <h3 className="mt-4 text-lg font-semibold text-foreground">No products found</h3>
              <p className="mt-2 text-muted-foreground">Try adjusting your filters</p>
              <Button
                variant="outline"
                className="mt-4"
                onClick={() => {
                  setSelectedCategory("All")
                  setSelectedPriceRange(0)
                }}
              >
                Clear Filters
              </Button>
            </div>
          )}
        </div>
      </main>

      {/* <Footer /> */}
    </div>
  )
}
