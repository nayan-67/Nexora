import { Truck, Shield, Clock, CreditCard } from "lucide-react"

const features = [
  {
    icon: Truck,
    title: "Free Shipping",
    description: "Free delivery on all orders over $50",
  },
  {
    icon: Shield,
    title: "Secure Payments",
    description: "100% secure payment processing",
  },
  {
    icon: Clock,
    title: "24/7 Support",
    description: "Round the clock customer service",
  },
  {
    icon: CreditCard,
    title: "Easy Returns",
    description: "30-day hassle-free return policy",
  },
]

export function FeaturesSection() {
  return (
    <section className="border-y border-border/40 bg-card/50">
      <div className="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <div className="grid grid-cols-2 gap-8 lg:grid-cols-4">
          {features.map((feature) => (
            <div key={feature.title} className="flex flex-col items-center text-center">
              <div className="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-primary/10">
                <feature.icon className="h-6 w-6 text-primary" />
              </div>
              <h3 className="font-semibold text-foreground">{feature.title}</h3>
              <p className="mt-1 text-sm text-muted-foreground">{feature.description}</p>
            </div>
          ))}
        </div>
      </div>
    </section>
  )
}
