import { useState, useMemo } from "react"
import { Link, useParams } from "react-router-dom"
import { ChevronLeft, Grid3X3, LayoutGrid, Heart, ShoppingBag, Star, SlidersHorizontal, ChevronDown } from "lucide-react"
import { Button } from "@/components/ui/button"
import { cn } from "@/lib/utils"
import { products, categoryData } from "@/lib/products"

function ProductCard({ product, isCompact }) {
  const [isLiked, setIsLiked] = useState(false)

  return (
    <div className="group relative flex flex-col">
      <div className={cn(
        "relative overflow-hidden rounded-2xl bg-muted",
        isCompact ? "aspect-square" : "aspect-4/5"
      )}>
        <Link href={`/products/${product.id}`}>
          <img
            src={product.image}
            alt={product.name}
            className="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
          />
        </Link>

        {/* Badges */}
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
            <span className="rounded-full bg-destructive px-2.5 py-1 text-xs font-medium text-destructive-foreground">
              Sale
            </span>
          )}
        </div>

        {/* Quick Actions */}
        <div className="absolute right-3 top-3 flex flex-col gap-2 opacity-0 transition-opacity duration-300 group-hover:opacity-100">
          <button
            onClick={() => setIsLiked(!isLiked)}
            className={cn(
              "flex h-9 w-9 items-center justify-center rounded-full bg-background/90 shadow-sm backdrop-blur-sm transition-colors",
              isLiked ? "text-destructive" : "text-foreground hover:text-destructive"
            )}
          >
            <Heart className={cn("h-4 w-4", isLiked && "fill-current")} />
          </button>
          <button className="flex h-9 w-9 items-center justify-center rounded-full bg-background/90 text-foreground shadow-sm backdrop-blur-sm transition-colors hover:bg-primary hover:text-primary-foreground">
            <ShoppingBag className="h-4 w-4" />
          </button>
        </div>
      </div>

      {/* Product Info */}
      <div className="mt-4 flex flex-col">
        <div className="flex items-center justify-between">
          <span className="text-xs text-muted-foreground">{product.category}</span>
          <div className="flex items-center gap-1">
            <Star className="h-3.5 w-3.5 fill-primary text-primary" />
            <span className="text-xs font-medium text-foreground">{product.rating}</span>
          </div>
        </div>
        <Link href={`/products/${product.id}`}>
          <h3 className="mt-1.5 font-medium text-foreground transition-colors group-hover:text-primary">
            {product.name}
          </h3>
        </Link>
        <div className="mt-2 flex items-center gap-2">
          <span className="font-semibold text-foreground">${product.price}</span>
          {product.originalPrice && (
            <span className="text-sm text-muted-foreground line-through">${product.originalPrice}</span>
          )}
        </div>
      </div>
    </div>
  )
}

export default function CategoryPage() {
  const params = useParams()
  const [sortBy, setSortBy] = useState("featured")
  const [isCompact, setIsCompact] = useState(false)
  const [showSortMenu, setShowSortMenu] = useState(false)
  const [priceRange, setPriceRange] = useState("all")
  const [showFilters, setShowFilters] = useState(false)

  // Find category data
  const category = categoryData.find(c => c.slug === params.slug)
  const categoryName = category?.name || params.slug.charAt(0).toUpperCase() + params.slug.slice(1)

  // Filter products by category
  const categoryProducts = useMemo(() => {
    let filtered = products.filter(p => p.category.toLowerCase() === params.slug)

    // Apply price filter
    if (priceRange !== "all") {
      switch (priceRange) {
        case "under-50":
          filtered = filtered.filter(p => p.price < 50)
          break
        case "50-100":
          filtered = filtered.filter(p => p.price >= 50 && p.price <= 100)
          break
        case "100-200":
          filtered = filtered.filter(p => p.price >= 100 && p.price <= 200)
          break
        case "over-200":
          filtered = filtered.filter(p => p.price > 200)
          break
      }
    }

    // Apply sorting
    switch (sortBy) {
      case "price-low":
        return [...filtered].sort((a, b) => a.price - b.price)
      case "price-high":
        return [...filtered].sort((a, b) => b.price - a.price)
      case "rating":
        return [...filtered].sort((a, b) => b.rating - a.rating)
      case "newest":
        return [...filtered].filter(p => p.isNew).concat([...filtered].filter(p => !p.isNew))
      default:
        return filtered
    }
  }, [params.slug, sortBy, priceRange])

  const sortOptions = [
    { value: "featured", label: "Featured" },
    { value: "newest", label: "Newest" },
    { value: "price-low", label: "Price: Low to High" },
    { value: "price-high", label: "Price: High to Low" },
    { value: "rating", label: "Top Rated" },
  ]

  const priceOptions = [
    { value: "all", label: "All Prices" },
    { value: "under-50", label: "Under $50" },
    { value: "50-100", label: "$50 - $100" },
    { value: "100-200", label: "$100 - $200" },
    { value: "over-200", label: "Over $200" },
  ]

  if (!category) {
    return (
      <div className="flex min-h-screen flex-col bg-background pt-18.75">
        {/* <Header /> */}
        <main className="flex flex-1 items-center justify-center">
          <div className="text-center">
            <h1 className="text-2xl font-bold text-foreground">Category not found</h1>
            <p className="mt-2 text-muted-foreground">The category you are looking for does not exist.</p>
            <Button asChild className="mt-4">
              <Link href="/categories">View All Categories</Link>
            </Button>
          </div>
        </main>
        {/* <Footer /> */}
      </div>
    )
  }

  return (
    <div className="flex min-h-screen flex-col bg-background">
      {/* <Header /> */}

      <main className="flex-1">
        {/* Hero Banner */}
        <div className="relative h-64 overflow-hidden bg-muted sm:h-90">
          <img
            src={category.image}
            alt={category.name}
            className="h-full w-full object-cover"
          />
          <div className="absolute inset-0 bg-linear-to-t from-background/90 via-background/50 to-transparent" />
          <div className="absolute inset-0 flex flex-col items-center justify-center px-4 text-center">
            <h1 className="text-4xl font-bold tracking-tight text-foreground sm:text-5xl" style={{ fontFamily: 'var(--font-heading)' }}>
              {category.name}
            </h1>
            <p className="mt-3 max-w-md text-lg text-muted-foreground">
              {category.description}
            </p>
          </div>
        </div>

        <div className="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
          {/* Breadcrumb */}
          <nav className="mb-8 flex items-center gap-2 text-sm">
            <Link href="/" className="text-muted-foreground transition-colors hover:text-foreground">
              Home
            </Link>
            <span className="text-muted-foreground">/</span>
            <Link href="/categories" className="text-muted-foreground transition-colors hover:text-foreground">
              Categories
            </Link>
            <span className="text-muted-foreground">/</span>
            <span className="text-foreground">{category.name}</span>
          </nav>

          {/* Toolbar */}
          <div className="mb-8 flex flex-wrap items-center justify-between gap-4">
            <div className="flex items-center gap-2">
              <span className="text-sm text-muted-foreground">
                {categoryProducts.length} {categoryProducts.length === 1 ? "product" : "products"}
              </span>
            </div>

            <div className="flex items-center gap-3">
              {/* Filters Button (Mobile) */}
              <Button
                variant="outline"
                size="sm"
                className="gap-2 lg:hidden"
                onClick={() => setShowFilters(!showFilters)}
              >
                <SlidersHorizontal className="h-4 w-4" />
                Filters
              </Button>

              {/* Price Filter */}
              <div className="relative hidden lg:block">
                <select
                  value={priceRange}
                  onChange={(e) => setPriceRange(e.target.value)}
                  className="h-9 appearance-none rounded-lg border border-input bg-background px-3 pr-8 text-sm text-foreground focus:outline-none focus:ring-2 focus:ring-ring"
                >
                  {priceOptions.map(option => (
                    <option key={option.value} value={option.value}>{option.label}</option>
                  ))}
                </select>
                <ChevronDown className="pointer-events-none absolute right-2 top-1/2 h-4 w-4 -translate-y-1/2 text-muted-foreground" />
              </div>

              {/* Sort Dropdown */}
              <div className="relative">
                <button
                  onClick={() => setShowSortMenu(!showSortMenu)}
                  className="flex h-9 items-center gap-2 rounded-lg border border-input bg-background px-3 text-sm text-foreground transition-colors hover:bg-accent"
                >
                  <span className="hidden sm:inline">Sort by:</span>
                  <span className="font-medium">{sortOptions.find(o => o.value === sortBy)?.label}</span>
                  <ChevronDown className={cn("h-4 w-4 transition-transform", showSortMenu && "rotate-180")} />
                </button>
                {showSortMenu && (
                  <>
                    <div className="fixed inset-0 z-40" onClick={() => setShowSortMenu(false)} />
                    <div className="absolute right-0 top-full z-50 mt-2 w-48 rounded-xl border border-border bg-card p-1 shadow-lg">
                      {sortOptions.map(option => (
                        <button
                          key={option.value}
                          onClick={() => {
                            setSortBy(option.value)
                            setShowSortMenu(false)
                          }}
                          className={cn(
                            "flex w-full items-center rounded-lg px-3 py-2 text-sm transition-colors",
                            sortBy === option.value
                              ? "bg-primary text-primary-foreground"
                              : "text-foreground hover:bg-accent"
                          )}
                        >
                          {option.label}
                        </button>
                      ))}
                    </div>
                  </>
                )}
              </div>

              {/* View Toggle */}
              <div className="hidden items-center gap-1 rounded-lg border border-input p-1 sm:flex">
                <button
                  onClick={() => setIsCompact(false)}
                  className={cn(
                    "flex h-7 w-7 items-center justify-center rounded-md transition-colors",
                    !isCompact ? "bg-primary text-primary-foreground" : "text-muted-foreground hover:text-foreground"
                  )}
                >
                  <LayoutGrid className="h-4 w-4" />
                </button>
                <button
                  onClick={() => setIsCompact(true)}
                  className={cn(
                    "flex h-7 w-7 items-center justify-center rounded-md transition-colors",
                    isCompact ? "bg-primary text-primary-foreground" : "text-muted-foreground hover:text-foreground"
                  )}
                >
                  <Grid3X3 className="h-4 w-4" />
                </button>
              </div>
            </div>
          </div>

          {/* Mobile Filters */}
          {showFilters && (
            <div className="mb-6 rounded-xl border border-border bg-card p-4 lg:hidden">
              <h3 className="mb-3 font-medium text-foreground">Price Range</h3>
              <div className="flex flex-wrap gap-2">
                {priceOptions.map(option => (
                  <button
                    key={option.value}
                    onClick={() => setPriceRange(option.value)}
                    className={cn(
                      "rounded-full px-3 py-1.5 text-sm transition-colors",
                      priceRange === option.value
                        ? "bg-primary text-primary-foreground"
                        : "bg-muted text-foreground hover:bg-accent"
                    )}
                  >
                    {option.label}
                  </button>
                ))}
              </div>
            </div>
          )}

          {/* Products Grid */}
          {categoryProducts.length > 0 ? (
            <div className={cn(
              "grid gap-6",
              isCompact
                ? "grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5"
                : "grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4"
            )}>
              {categoryProducts.map(product => (
                <ProductCard key={product.id} product={product} isCompact={isCompact} />
              ))}
            </div>
          ) : (
            <div className="flex flex-col items-center justify-center py-16 text-center">
              <div className="flex h-16 w-16 items-center justify-center rounded-full bg-muted">
                <ShoppingBag className="h-8 w-8 text-muted-foreground" />
              </div>
              <h3 className="mt-4 text-lg font-medium text-foreground">No products found</h3>
              <p className="mt-2 text-muted-foreground">Try adjusting your filters</p>
              <Button
                variant="outline"
                className="mt-4"
                onClick={() => setPriceRange("all")}
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
