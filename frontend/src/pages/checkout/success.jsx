import { Link, useParams } from "react-router-dom"
import { CheckCircle2, Package, Mail, ArrowRight } from "lucide-react"
import { Button } from "@/components/ui/button"
import { useEffect, useState } from "react";
import api from "@/lib/api"

export default function CheckoutSuccessPage() {
  const param = useParams();
  const [orderNumber, setOrderNumber] = useState('')
  useEffect(() => {
    let active = true
    api.get(`/order/${param.ordid}`)
      .then((res) => {
        if (active) {
          setOrderNumber(res.data)
        }
      })
      .catch((err) => {
        console.log(err)
      })
    return () => { active = false }
  }, [])

  return (
    <div className="flex min-h-screen flex-col bg-background pt-18.75">
      {/* <Header /> */}

      <main className="flex flex-1 items-center justify-center px-4 py-16">
        <div className="mx-auto max-w-lg text-center">
          <div className="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-green-100">
            <CheckCircle2 className="h-10 w-10 text-green-600" />
          </div>

          <h1 className="mt-6 text-3xl font-bold tracking-tight text-foreground sm:text-4xl" style={{ fontFamily: 'var(--font-heading)' }}>
            Order Confirmed!
          </h1>
          <p className="mt-4 text-lg text-muted-foreground">
            Thank you for your purchase. Your order has been received and is being processed.
          </p>

          <div className="mt-8 rounded-2xl border border-border/60 bg-card p-6">
            <div className="flex items-center justify-between border-b border-border/40 pb-4">
              <span className="text-sm text-muted-foreground">Order Number</span>
              <span className="font-mono font-semibold text-foreground">{orderNumber}</span>
            </div>
            <div className="flex items-center justify-between py-4">
              <span className="text-sm text-muted-foreground">Estimated Delivery</span>
              <span className="font-medium text-foreground">3-5 Business Days</span>
            </div>
          </div>

          <div className="mt-8 grid gap-4 sm:grid-cols-2">
            <div className="flex items-center gap-3 rounded-xl border border-border/60 bg-card p-4">
              <div className="flex h-10 w-10 items-center justify-center rounded-full bg-primary/10">
                <Mail className="h-5 w-5 text-primary" />
              </div>
              <div className="text-left">
                <p className="text-sm font-medium text-foreground">Email Sent</p>
                <p className="text-xs text-muted-foreground">Confirmation details</p>
              </div>
            </div>
            <div className="flex items-center gap-3 rounded-xl border border-border/60 bg-card p-4">
              <div className="flex h-10 w-10 items-center justify-center rounded-full bg-primary/10">
                <Package className="h-5 w-5 text-primary" />
              </div>
              <div className="text-left">
                <p className="text-sm font-medium text-foreground">Track Order</p>
                <p className="text-xs text-muted-foreground">In your account</p>
              </div>
            </div>
          </div>

          <div className="mt-8 flex flex-col gap-3 sm:flex-row sm:justify-center">
            <Button asChild>
              <Link to="/orders" className="gap-2">
                View Order History
                <ArrowRight className="h-4 w-4" />
              </Link>
            </Button>
            <Button variant="outline" asChild>
              <Link to="/shop">Continue Shopping</Link>
            </Button>
          </div>
        </div>
      </main>

      {/* <Footer /> */}
    </div>
  )
}
