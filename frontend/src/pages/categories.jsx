import { Link } from "react-router-dom"
import { ArrowRight } from "lucide-react"
import { categoryData, products } from "@/lib/products"

function CategoryCard({ category }) {
  const productCount = products.filter(p => p.category === category.name).length

  return (
    <Link
      to={`/category/${category.slug}`}
      className="group relative flex aspect-4/3 flex-col overflow-hidden rounded-2xl bg-muted"
    >
      <img
        src={category.image}
        alt={category.name}
        className="absolute inset-0 h-full w-full object-cover transition-transform duration-700 group-hover:scale-110"
      />
      <div className="absolute inset-0 bg-linear-to-t from-foreground/90 via-foreground/40 to-transparent transition-opacity duration-300 group-hover:from-foreground/95" />

      <div className="relative mt-auto p-6">
        <span className="text-sm text-primary-foreground/80">{productCount} Products</span>
        <h3 className="mt-1 text-2xl font-bold text-primary-foreground" style={{ fontFamily: 'var(--font-heading)' }}>
          {category.name}
        </h3>
        <p className="mt-2 text-sm text-primary-foreground/70 line-clamp-2">
          {category.description}
        </p>
        <div className="mt-4 flex items-center gap-2 text-sm font-medium text-primary-foreground">
          <span>Shop Now</span>
          <ArrowRight className="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1" />
        </div>
      </div>
    </Link>
  )
}

export default function CategoriesPage() {
  return (
    <div className="flex min-h-screen flex-col bg-background pt-18.75">
      {/* <Header /> */}

      <main className="flex-1">
        <div className="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
          {/* Header */}
          <div className="text-center">
            <h1 className="text-4xl font-bold tracking-tight text-foreground sm:text-5xl" style={{ fontFamily: 'var(--font-heading)' }}>
              Shop by Category
            </h1>
            <p className="mx-auto mt-4 max-w-xl text-lg text-muted-foreground">
              Browse our curated collections and find exactly what you&apos;re looking for
            </p>
          </div>

          {/* Categories Grid */}
          <div className="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-2">
            {categoryData.map((category) => (
              <CategoryCard key={category.slug} category={category} />
            ))}
          </div>

          {/* Featured Section */}
          <div className="mt-16 rounded-3xl bg-linear-to-br from-primary/10 via-primary/5 to-transparent p-8 sm:p-12">
            <div className="flex flex-col items-center text-center">
              <span className="rounded-full bg-primary/20 px-4 py-1.5 text-sm font-medium text-primary">
                Special Offer
              </span>
              <h2 className="mt-4 text-3xl font-bold tracking-tight text-foreground sm:text-4xl" style={{ fontFamily: 'var(--font-heading)' }}>
                New Arrivals Collection
              </h2>
              <p className="mt-3 max-w-lg text-muted-foreground">
                Discover our latest products across all categories with exclusive launch prices
              </p>
              <Link
                to="/shop?filter=new"
                className="mt-6 inline-flex items-center gap-2 rounded-full bg-primary px-6 py-3 font-medium text-primary-foreground transition-colors hover:bg-primary/90"
              >
                Explore New Arrivals
                <ArrowRight className="h-4 w-4" />
              </Link>
            </div>
          </div>
        </div>
      </main>

      {/* <Footer /> */}
    </div>
  )
}
