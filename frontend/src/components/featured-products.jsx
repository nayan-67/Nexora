import { useEffect, useState } from "react"
import { Link } from "react-router-dom"
import { Heart, ShoppingBag, Star } from "lucide-react"
import { Button } from "@/components/ui/button"
import { cn } from "@/lib/utils"
import api from "@/lib/api"
const apiBase = api.defaults.baseURL.replace(/\/api\/?$/, "")


function ProductCard({ product, category }) {
  const [isLiked, setIsLiked] = useState(false)

  useEffect(() => {
    let active = true
    api.get("/wishlist")
      .then((res) => {
        if (active) {
          let wish = res.data;
          wish.map(item => {
            setIsLiked(item.prd_id == product.id);
          })
        }
      })
      .catch((err) => {
        // console.error("Error:", err.response?.data?.message || err.message);
      })
    return () => {
      active = false
    }
  }, [])

  const handleAddWish = () => {
    let cardData = {
      prdId: product.id,
      prdType: product.type,
      prdSku: product.sku,
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

  const listingDate = new Date(product.created_at)
  const today = new Date();

  const checkDate = new Date();
  checkDate.setDate(today.getDate() - 7);
  const isNew = listingDate > checkDate

  return (
    <div className="group relative flex flex-col">
      <div className="relative aspect-square overflow-hidden rounded-2xl bg-muted">
        <Link to={`/products/${product.id}`} target="_blank" rel="noopener noreferrer">
          <img
            src={`${apiBase}/uploads/${product.type == 2 ? 'var' : 'prd'}_md_${product.featured_image}`}
            alt={product.name}
            className="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
          />
        </Link>

        <div className="absolute left-3 top-3 flex flex-col gap-2">
          {isNew && (
            <span className="rounded-full bg-primary px-2.5 py-1 text-xs font-medium text-primary-foreground">
              New
            </span>
          )}
          {product.isBestseller && (
            <span className="rounded-full bg-foreground px-2.5 py-1 text-xs font-medium text-background">
              Bestseller
            </span>
          )}
          {product.sale_price && (
            <span className="rounded-full bg-destructive px-2.5 py-1 text-xs font-medium text-white">
              Sale
            </span>
          )}
        </div>
        {product.type == 1 && (
          <div className="absolute right-3 top-3 flex flex-col gap-2 opacity-0 transition-opacity group-hover:opacity-100">
            <button
              onClick={handleAddWish}
              className={cn(
                "flex h-9 w-9 items-center justify-center rounded-full bg-card/90 shadow-sm backdrop-blur-sm transition-colors",
                isLiked ? "text-destructive" : "text-muted-foreground hover:text-foreground"
              )}
            >
              <Heart className={cn("h-4 w-4 cursor-pointer", isLiked ? "fill-current" : "fill-muted")} />
            </button>
          </div>
        )}

        {/* <div className="absolute inset-x-3 bottom-3 translate-y-2 opacity-0 transition-all group-hover:translate-y-0 group-hover:opacity-100">
          <Button className="w-full gap-2 shadow-lg cursor-pointer" size="sm">
            <ShoppingBag className="h-4 w-4" />
            Add to Cart
          </Button>
        </div> */}
      </div>

      <div className="mt-4 flex flex-col">
        <span className="text-xs font-medium text-muted-foreground">{category}</span>
        <Link to={`/products/${product.id}`} className="mt-1 font-medium text-foreground transition-colors hover:text-primary">
          {product.name}
        </Link>
        <div className="mt-2 flex items-center gap-2">
          <div className="flex items-center gap-1">
            <Star className="h-3.5 w-3.5 fill-primary text-primary" />
            <span className="text-sm font-medium text-foreground">4.8</span>
          </div>
          <span className="text-sm text-muted-foreground">(9)</span>
        </div>
        <div className="mt-2 flex items-center gap-2">
          {product.sale_price ? (
            <>
              <span className="text-lg font-semibold text-foreground">₹ {product.sale_price}</span>
              <span className="text-sm text-muted-foreground line-through">₹ {product.price}</span>
            </>
          ) : (
            <span className="text-lg font-semibold text-foreground">₹ {product.price}</span>
          )}
        </div>
      </div>
    </div>
  )
}

export function FeaturedProducts() {

  const [products, setProducts] = useState([]);
  const [sortCategory, setSortCategory] = useState([])

  useEffect(() => {
    let active = true
    // setIsLoading(true)
    const loadShopData = async () => {
      try {
        const [catResponse, productResponse] = await Promise.all([
          api.get("/sortcategories"),
          api.get("/featured-products"),
        ])

        if (!active) return

        setSortCategory(catResponse.status === 200 ? catResponse.data : [])
        setProducts(productResponse.status === 200 ? productResponse.data : [])
      } catch (error) {
        if (!active) return

        setSortCategory([])
        setProducts([])
        console.error("Error fetching data:", error)
      }
    }

    loadShopData()

    return () => {
      active = false
    }
  }, [])

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
            <ProductCard key={product.id} product={product} category={sortCategory.find(cat => Number(cat.id) === Number(product.category_id))?.name} />
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
