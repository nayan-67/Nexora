import { Link } from "react-router-dom"
import { Button } from "@/components/ui/button"
import { ArrowRight } from "lucide-react"
import { ShinyText } from "@/components/lightswind/shiny-text"
import { ThreeDMarquee } from "@/components/lightswind/3d-marquee"
import { CountUp } from "@/components/lightswind/count-up"

export function HeroSection() {
  const images = [
    {
      src: "https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=400&h=400&fit=crop&q=80",
      alt: "Premium Wireless Headphones"
    },
    {
      src: "https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=400&h=400&fit=crop&q=80",
      alt: "Minimalist Watch Collection"
    },
    {
      src: "https://images.unsplash.com/photo-1572635196237-14b3f281503f?w=400&h=400&fit=crop&q=80",
      alt: "Designer Sunglasses"
    },
    {
      src: "https://images.unsplash.com/photo-1589003077984-894e133dabab?w=400&h=400&fit=crop&q=80",
      alt: "Smart Home Speaker"
    },
    {
      src: "https://images.unsplash.com/photo-1548036328-c9fa89d128fa?w=600&h=600&fit=crop&q=80",
      alt: "Leather Crossbody Bag"
    },
    {
      src: "https://images.unsplash.com/photo-1578500494198-246f612d3b3d?w=600&h=600&fit=crop&q=80",
      alt: "Ceramic Vase Set"
    },
    {
      src: "https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=600&h=600&fit=crop&q=80",
      alt: "Premium Cotton T-Shirt"
    },
    {
      src: "https://images.unsplash.com/photo-1609091839311-d5365f9ff1c5?w=600&h=600&fit=crop&q=80",
      alt: "Portable Charger Pro"
    },
  ];

  return (
    <section className="relative overflow-hidden bg-linear-to-b from-background to-muted/30 pt-18.75">
      {/* Background decorative elements */}
      <div className="pointer-events-none absolute inset-0 overflow-hidden">
        <div className="absolute -right-40 -top-40 h-80 w-80 rounded-full bg-primary/5 blur-3xl" />
        <div className="absolute -bottom-40 -left-40 h-80 w-80 rounded-full bg-primary/5 blur-3xl" />
      </div>

      <div className="relative mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
        <div className="grid items-center gap-12 lg:grid-cols-2 lg:gap-16">
          {/* Content */}
          <div className="flex flex-col items-center text-center lg:items-start lg:text-left">
            <span className="mb-6 inline-flex items-center rounded-full bg-primary/10 px-4 py-1.5 text-xs font-medium text-primary">
              New Collection 2026
            </span>
            <h1 className="text-balance text-4xl font-bold tracking-tight text-foreground sm:text-5xl lg:text-6xl" style={{ fontFamily: 'var(--font-heading)' }}>
              <ShinyText baseColor="oklch(0.13 0.02 280)"
                shineColor="rgba(147, 51, 234, 0.9)"
                shineWidth={2}
                size="5xl"
                weight="bold"
                speed={8}>Upgrade</ShinyText><br />
              <ShinyText baseColor="oklch(0.13 0.02 280)"
                shineColor="rgba(147, 51, 234, 0.9)"
                shineWidth={2}
                size="5xl"
                weight="bold"
                speed={8}>Your</ShinyText>{" "}
              <span className="bg-linear-to-r from-primary to-primary/60 bg-clip-text text-transparent">
                Lifestyle
              </span>
            </h1>
            <p className="mt-6 max-w-lg text-pretty text-lg text-muted-foreground">
              Discover curated collections of premium products designed to elevate every aspect of your daily life.
            </p>
            <div className="mt-8 flex flex-col gap-4 sm:flex-row">
              <Button size="lg" className="gap-2 px-8 shadow-lg shadow-primary/20" asChild>
                <Link to="/shop">
                  Shop Now
                  <ArrowRight className="h-4 w-4" />
                </Link>
              </Button>
              <Button size="lg" variant="outline" className="px-8" asChild>
                <Link to="/categories">Explore Categories</Link>
              </Button>
            </div>
            <div className="mt-10 flex items-center gap-8">
              <div>
                <div className="text-2xl font-bold text-foreground" style={{ fontFamily: 'var(--font-heading)' }}>
                  <CountUp
                    value={50}
                    suffix="K+"
                    duration={4}
                    className="text-2xl font-bold text-foreground"
                  />
                </div>
                <p className="text-sm text-muted-foreground">Happy Customers</p>
              </div>
              <div className="h-10 w-px bg-border" />
              <div>
                <div className="text-2xl font-bold text-foreground" style={{ fontFamily: 'var(--font-heading)' }}>
                  <CountUp
                    value={4.9}
                    decimals={1}
                    duration={4}
                    className="text-2xl font-bold text-foreground"
                  />
                  </div>
                <p className="text-sm text-muted-foreground">Average Rating</p>
              </div>
              <div className="h-10 w-px bg-border" />
              <div>
                <div className="text-2xl font-bold text-foreground" style={{ fontFamily: 'var(--font-heading)' }}>
                  <CountUp
                    value={500}
                    suffix="K+"
                    duration={4}
                    className="text-2xl font-bold text-foreground"
                  />
                </div>
                <p className="text-sm text-muted-foreground">Products</p>
              </div>
            </div>
          </div>

          {/* Hero Image */}
          <div className="relative">
            <div className="relative aspect-square overflow-hidden rounded-3xl bg-linear-to-br from-primary/20 via-primary/10 to-transparent p-1">
              <div className="h-full w-full overflow-hidden rounded-[calc(1.5rem-4px)] bg-muted opacity-50 absolute inset-0">
                <img
                  src="https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=800&h=800&fit=crop&q=80"
                  alt="Premium shopping experience"
                  className="h-full w-full object-cover"
                />
              </div>
              <ThreeDMarquee images={images} />
            </div>
            {/* Floating badge */}
            <div className="absolute bottom-5 left-5 rounded-2xl border border-border/50 bg-card p-4 shadow-xl">
              <div className="flex items-center gap-3">
                <div className="flex h-12 w-12 items-center justify-center rounded-full bg-primary/10">
                  <span className="text-lg">🚚</span>
                </div>
                <div>
                  <p className="font-semibold text-foreground">Free Shipping</p>
                  <p className="text-sm text-muted-foreground">On orders over $50</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  )
}
