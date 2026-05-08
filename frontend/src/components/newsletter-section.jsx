import { useState } from "react"
import { Button } from "@/components/ui/button"
import { Input } from "@/components/ui/input"
import { ArrowRight, Sparkles } from "lucide-react"

export function NewsletterSection() {
  const [email, setEmail] = useState("");
  const [isSubmitted, setIsSubmitted] = useState(false)

  const handleSubmit = (e) => {
    e.preventDefault()
    if (email) {
      setIsSubmitted(true)
    }
  }

  return (
    <section className="bg-linear-to-br from-primary/5 via-background to-primary/5 py-16 sm:py-24">
      <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div className="relative overflow-hidden rounded-3xl bg-linear-to-br from-foreground to-foreground/90 px-6 py-16 sm:px-12 sm:py-20 lg:px-16">
          {/* Background decoration */}
          <div className="pointer-events-none absolute -right-20 -top-20 h-60 w-60 rounded-full bg-primary/20 blur-3xl" />
          <div className="pointer-events-none absolute -bottom-20 -left-20 h-60 w-60 rounded-full bg-primary/20 blur-3xl" />

          <div className="relative mx-auto max-w-2xl text-center">
            <div className="mb-6 inline-flex items-center gap-2 rounded-full bg-primary/20 px-4 py-1.5">
              <Sparkles className="h-4 w-4 text-primary" />
              <span className="text-sm font-medium text-primary">Exclusive Offers</span>
            </div>

            <h2 className="text-balance text-3xl font-bold tracking-tight text-background sm:text-4xl" style={{ fontFamily: 'var(--font-heading)' }}>
              Join the Nexora Community
            </h2>
            <p className="mt-4 text-lg text-background/70">
              Subscribe to get exclusive access to new arrivals, special offers, and 15% off your first order.
            </p>

            {isSubmitted ? (
              <div className="mt-8 rounded-xl bg-primary/20 p-6">
                <p className="text-lg font-medium text-background">Welcome to the community!</p>
                <p className="mt-2 text-background/70">Check your inbox for your 15% discount code.</p>
              </div>
            ) : (
              <form onSubmit={handleSubmit} className="mt-8 flex flex-col gap-3 sm:flex-row sm:gap-4">
                <Input
                  type="email"
                  placeholder="Enter your email"
                  value={email}
                  onChange={(e) => setEmail(e.target.value)}
                  className="h-12 flex-1 border-background/20 bg-background/10 text-background placeholder:text-background/50 focus-visible:border-primary focus-visible:ring-primary"
                  required
                />
                <Button type="submit" size="lg" className="h-12 gap-2 whitespace-nowrap cursor-pointer">
                  Subscribe
                  <ArrowRight className="h-4 w-4" />
                </Button>
              </form>
            )}

            <p className="mt-4 text-sm text-background/50">
              By subscribing, you agree to our Privacy Policy. Unsubscribe anytime.
            </p>
          </div>
        </div>
      </div>
    </section>
  )
}
