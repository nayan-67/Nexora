import { Star } from "lucide-react"

const testimonials = [
  {
    id: 1,
    content:
      "Nexora has completely changed how I shop online. The quality of products is exceptional, and the customer service is top-notch.",
    author: "Sarah Johnson",
    role: "Verified Buyer",
    avatar: "https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=100&h=100&fit=crop&q=80",
    rating: 5,
  },
  {
    id: 2,
    content:
      "I love the curated collections. Every piece I&apos;ve purchased has exceeded my expectations. Fast shipping too!",
    author: "Michael Chen",
    role: "Premium Member",
    avatar: "https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&h=100&fit=crop&q=80",
    rating: 5,
  },
  {
    id: 3,
    content:
      "The attention to detail in packaging and product quality shows they truly care about the customer experience.",
    author: "Emily Rodriguez",
    role: "Verified Buyer",
    avatar: "https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=100&h=100&fit=crop&q=80",
    rating: 5,
  },
]

export function TestimonialsSection() {
  return (
    <section className="bg-background py-16 sm:py-24">
      <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div className="mb-12 flex flex-col items-center text-center">
          <h2 className="text-balance text-3xl font-bold tracking-tight text-foreground sm:text-4xl" style={{ fontFamily: 'var(--font-heading)' }}>
            What Our Customers Say
          </h2>
          <p className="mt-4 max-w-2xl text-lg text-muted-foreground">
            Join thousands of satisfied customers who trust Nexora
          </p>
        </div>

        <div className="grid gap-8 md:grid-cols-3">
          {testimonials.map((testimonial) => (
            <div
              key={testimonial.id}
              className="flex flex-col rounded-2xl border border-border/50 bg-card p-6 shadow-sm transition-shadow hover:shadow-md"
            >
              {/* Rating */}
              <div className="flex gap-1">
                {[...Array(testimonial.rating)].map((_, i) => (
                  <Star key={i} className="h-4 w-4 fill-primary text-primary" />
                ))}
              </div>

              {/* Content */}
              <p className="mt-4 flex-1 text-muted-foreground">{testimonial.content}</p>

              {/* Author */}
              <div className="mt-6 flex items-center gap-3">
                <img
                  src={testimonial.avatar}
                  alt={testimonial.author}
                  className="h-10 w-10 rounded-full object-cover"
                />
                <div>
                  <p className="font-medium text-foreground">{testimonial.author}</p>
                  <p className="text-sm text-muted-foreground">{testimonial.role}</p>
                </div>
              </div>
            </div>
          ))}
        </div>
      </div>
    </section>
  )
}
