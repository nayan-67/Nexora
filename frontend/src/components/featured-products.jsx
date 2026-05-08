import { useState } from "react"
import { Link } from "react-router-dom"
import { Heart, ShoppingBag, Star } from "lucide-react"
import { Button } from "@/components/ui/button"
import { cn } from "@/lib/utils"

const products = [
  {
    id: 1,
    name: "Premium Wireless Headphones",
    price: 299,
    originalPrice: 349,
    rating: 4.9,
    reviews: 128,
    image: "https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=400&h=400&fit=crop&q=80",
    category: "Electronics",
    isNew: true,
  },
  {
    id: 2,
    name: "Minimalist Watch Collection",
    price: 189,
    rating: 4.8,
    reviews: 89,
    image: "https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=400&h=400&fit=crop&q=80",
    category: "Accessories",
    isBestseller: true,
  },
  {
    id: 3,
    name: "Designer Sunglasses",
    price: 159,
    originalPrice: 199,
    rating: 4.7,
    reviews: 156,
    image: "https://images.unsplash.com/photo-1572635196237-14b3f281503f?w=400&h=400&fit=crop&q=80",
    category: "Accessories",
  },
  {
    id: 4,
    name: "Smart Home Speaker",
    price: 129,
    rating: 4.6,
    reviews: 234,
    image: "https://images.unsplash.com/photo-1589003077984-894e133dabab?w=400&h=400&fit=crop&q=80",
    category: "Electronics",
    isNew: true,
  },
  {
    id: 5,
    name: "Leather Crossbody Bag",
    price: 245,
    rating: 4.9,
    reviews: 67,
    image: "https://images.unsplash.com/photo-1548036328-c9fa89d128fa?w=400&h=400&fit=crop&q=80",
    category: "Fashion",
    isBestseller: true,
  },
  {
    id: 6,
    name: "Ceramic Vase Set",
    price: 89,
    originalPrice: 119,
    rating: 4.8,
    reviews: 45,
    image: "https://images.unsplash.com/photo-1578500494198-246f612d3b3d?w=400&h=400&fit=crop&q=80",
    category: "Home",
  },
  {
    id: 7,
    name: "Premium Cotton T-Shirt",
    price: 49,
    rating: 4.7,
    reviews: 312,
    image: "https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=400&h=400&fit=crop&q=80",
    category: "Fashion",
  },
  {
    id: 8,
    name: "Portable Charger Pro",
    price: 79,
    rating: 4.8,
    reviews: 189,
    image: "https://images.unsplash.com/photo-1609091839311-d5365f9ff1c5?w=400&h=400&fit=crop&q=80",
    category: "Electronics",
    isNew: true,
  },
]

function ProductCard({ product }) {
  const [isLiked, setIsLiked] = useState(false)

  return (
    <div className="group relative flex flex-col">
      {/* Image Container */}
      <div className="relative aspect-square overflow-hidden rounded-2xl bg-muted">
        <Link to={`/products/${product.id}`} >
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

        {/* Add to Cart Button */}
        <div className="absolute inset-x-3 bottom-3 translate-y-2 opacity-0 transition-all group-hover:translate-y-0 group-hover:opacity-100">
          <Button className="w-full gap-2 shadow-lg cursor-pointer" size="sm">
            <ShoppingBag className="h-4 w-4" />
            Add to Cart
          </Button>
        </div>
      </div>

      {/* Product Info */}
      <div className="mt-4 flex flex-col">
        <span className="text-xs font-medium text-muted-foreground">{product.category}</span>
        <Link to={`/products/${product.id}`} className="mt-1 font-medium text-foreground hover:text-primary">
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

export function FeaturedProducts() {
  return (
    <section className="bg-muted/30 py-16 sm:py-24">
      <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div className="mb-12 flex flex-col items-center text-center">
          <h2 className="text-balance text-3xl font-bold tracking-tight text-foreground sm:text-4xl" style={{ fontFamily: 'var(--font-heading)' }}>
            Featured Products
          </h2>
          <p className="mt-4 max-w-2xl text-lg text-muted-foreground">
            Handpicked favorites from our latest collections
          </p>
        </div>

        <div className="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
          {products.map((product) => (
            <ProductCard key={product.id} product={product} />
          ))}
        </div>

        <div className="mt-12 flex justify-center">
          <Button variant="outline" size="lg" asChild>
            <Link to="/shop">View All Products</Link>
          </Button>
        </div>
      </div>
    </section>
  )
}
