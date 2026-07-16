import { Link } from "react-router-dom"
import { ArrowRight } from "lucide-react"
import { useState } from "react";
import api from "@/lib/api"

// const categories = [
//   {
//     name: "Fashion",
//     description: "Trending styles",
//     image: "https://images.unsplash.com/photo-1445205170230-053b83016050?w=600&h=400&fit=crop&q=80",
//     to: "/categories/fashion",
//     itemCount: 150,
//   },
//   {
//     name: "Electronics",
//     description: "Latest gadgets",
//     image: "https://images.unsplash.com/photo-1468495244123-6c6c332eeece?w=600&h=400&fit=crop&q=80",
//     to: "/categories/electronics",
//     itemCount: 89,
//   },
//   {
//     name: "Accessories",
//     description: "Complete your look",
//     image: "https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=600&h=400&fit=crop&q=80",
//     to: "/categories/accessories",
//     itemCount: 210,
//   },
//   {
//     name: "Home",
//     description: "Elevate your space",
//     image: "https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=600&h=400&fit=crop&q=80",
//     to: "/categories/home",
//     itemCount: 175,
//   },
// ]

export function CategoriesSection() {

  const [categories, setCategories] = useState([]);

  useState(() => {
    let active = true;

    api.get("/categories")
      .then((response) => {
        if (active) {
          setCategories(response.data || []);
        }
      })
      .catch((error) => {
        toast.error(error.response?.data?.message || "Failed to load categories.");
      });

    return () => {
      active = false;
    };
  });
  const apiBase = api.defaults.baseURL.replace(/\/api\/?$/, "");
  
  return (
    <section className="bg-background py-16 sm:py-24">
      <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div className="mb-12 flex flex-col items-center text-center">
          <h2 className="text-balance text-3xl font-bold tracking-tight text-foreground sm:text-4xl" style={{ fontFamily: 'var(--font-heading)' }}>
            Shop by Category
          </h2>
          <p className="mt-4 max-w-2xl text-lg text-muted-foreground">
            Explore our carefully curated collections across all categories
          </p>
        </div>

        <div className="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
          {categories.map((category) => (
            <Link
              key={category.name}
              to={`/category/${category.slug}`}
              className="group relative overflow-hidden rounded-2xl bg-card shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-lg"
            >
              <div className="aspect-4/3 overflow-hidden">
                <img
                  src={`${apiBase}/uploads/cat_${category.image}`}
                  alt={category.name}
                  className="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                />
                <div className="absolute inset-0 bg-linear-to-t from-foreground/80 via-foreground/20 to-transparent" />
              </div>
              <div className="absolute inset-x-0 bottom-0 p-5">
                <div className="flex items-end justify-between">
                  <div>
                    <h3 className="text-lg font-semibold text-card">{category.name}</h3>
                    <p className="text-sm text-card/80">{category.total_products} products</p>
                  </div>
                  <div className="flex h-10 w-10 items-center justify-center rounded-full bg-card/20 backdrop-blur-sm transition-colors group-hover:bg-card">
                    <ArrowRight className="h-5 w-5 text-card transition-colors group-hover:text-foreground" />
                  </div>
                </div>
              </div>
            </Link>
          ))}
        </div>
      </div>
    </section>
  )
}
