import { useState } from "react"
import { Link } from "react-router-dom"
import { Package, ChevronRight, Truck, CheckCircle2, Clock, XCircle } from "lucide-react"
import { Button } from "@/components/ui/button"
import { cn } from "@/lib/utils"

const orders = [
  {
    id: "NX-8FK2JH",
    date: "March 28, 2026",
    status: "delivered",
    total: 922,
    items: [
      {
        id: 1,
        name: "Premium Wireless Headphones",
        price: 299,
        image: "https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=100&h=100&fit=crop&q=80",
        quantity: 1,
      },
      {
        id: 2,
        name: "Minimalist Watch Collection",
        price: 189,
        image: "https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=100&h=100&fit=crop&q=80",
        quantity: 2,
      },
      {
        id: 5,
        name: "Leather Crossbody Bag",
        price: 245,
        image: "https://images.unsplash.com/photo-1548036328-c9fa89d128fa?w=100&h=100&fit=crop&q=80",
        quantity: 1,
      },
    ],
  },
  {
    id: "NX-3PQ9MN",
    date: "March 15, 2026",
    status: "shipped",
    trackingNumber: "1Z999AA10123456784",
    total: 328,
    items: [
      {
        id: 4,
        name: "Smart Home Speaker",
        price: 129,
        image: "https://images.unsplash.com/photo-1589003077984-894e133dabab?w=100&h=100&fit=crop&q=80",
        quantity: 1,
      },
      {
        id: 3,
        name: "Designer Sunglasses",
        price: 159,
        image: "https://images.unsplash.com/photo-1572635196237-14b3f281503f?w=100&h=100&fit=crop&q=80",
        quantity: 1,
      },
    ],
  },
  {
    id: "NX-7YT5WX",
    date: "February 22, 2026",
    status: "processing",
    total: 79,
    items: [
      {
        id: 8,
        name: "Portable Charger Pro",
        price: 79,
        image: "https://images.unsplash.com/photo-1609091839311-d5365f9ff1c5?w=100&h=100&fit=crop&q=80",
        quantity: 1,
      },
    ],
  },
  {
    id: "NX-1AB2CD",
    date: "January 10, 2026",
    status: "cancelled",
    total: 89,
    items: [
      {
        id: 6,
        name: "Ceramic Vase Set",
        price: 89,
        image: "https://images.unsplash.com/photo-1578500494198-246f612d3b3d?w=100&h=100&fit=crop&q=80",
        quantity: 1,
      },
    ],
  },
]

const statusConfig = {
  delivered: {
    label: "Delivered",
    icon: CheckCircle2,
    color: "text-green-600",
    bg: "bg-green-100",
  },
  shipped: {
    label: "Shipped",
    icon: Truck,
    color: "text-blue-600",
    bg: "bg-blue-100",
  },
  processing: {
    label: "Processing",
    icon: Clock,
    color: "text-amber-600",
    bg: "bg-amber-100",
  },
  cancelled: {
    label: "Cancelled",
    icon: XCircle,
    color: "text-red-600",
    bg: "bg-red-100",
  },
}

function OrderCard({ order }) {
  const [isExpanded, setIsExpanded] = useState(false)
  const status = statusConfig[order.status]
  const StatusIcon = status.icon

  return (
    <div className="overflow-hidden rounded-2xl border border-border/60 bg-card">
      {/* Order Header */}
      <button
        onClick={() => setIsExpanded(!isExpanded)}
        className="flex w-full items-center justify-between p-6 text-left transition-colors hover:bg-muted/50"
      >
        <div className="flex items-center gap-4">
          <div className={cn("flex h-12 w-12 items-center justify-center rounded-xl", status.bg)}>
            <StatusIcon className={cn("h-6 w-6", status.color)} />
          </div>
          <div>
            <div className="flex items-center gap-3">
              <span className="font-mono font-semibold text-foreground">{order.id}</span>
              <span className={cn(
                "rounded-full px-2.5 py-0.5 text-xs font-medium",
                status.bg,
                status.color
              )}>
                {status.label}
              </span>
            </div>
            <p className="mt-1 text-sm text-muted-foreground">
              {order.date} &bull; {order.items.length} {order.items.length === 1 ? "item" : "items"}
            </p>
          </div>
        </div>
        <div className="flex items-center gap-4">
          <span className="text-lg font-semibold text-foreground">${order.total}</span>
          <ChevronRight className={cn(
            "h-5 w-5 text-muted-foreground transition-transform",
            isExpanded && "rotate-90"
          )} />
        </div>
      </button>

      {/* Order Details */}
      {isExpanded && (
        <div className="border-t border-border/40 p-6">
          {/* Tracking Info */}
          {order.status === "shipped" && order.trackingNumber && (
            <div className="mb-6 rounded-xl bg-blue-50 p-4">
              <p className="text-sm font-medium text-blue-900">Tracking Number</p>
              <p className="mt-1 font-mono text-sm text-blue-700">{order.trackingNumber}</p>
            </div>
          )}

          {/* Items */}
          <div className="space-y-4">
            {order.items.map((item) => (
              <div key={item.id} className="flex items-center gap-4">
                <div className="h-16 w-16 overflow-hidden rounded-xl bg-muted">
                  <img src={item.image} alt={item.name} className="h-full w-full object-cover" />
                </div>
                <div className="flex-1">
                  <Link
                    to={`/products/${item.id}`}
                    className="font-medium text-foreground transition-colors hover:text-primary"
                  >
                    {item.name}
                  </Link>
                  <p className="text-sm text-muted-foreground">
                    Qty: {item.quantity} &bull; ${item.price}
                  </p>
                </div>
                <p className="font-medium text-foreground">
                  ${item.price * item.quantity}
                </p>
              </div>
            ))}
          </div>

          {/* Actions */}
          <div className="mt-6 flex flex-wrap gap-3 border-t border-border/40 pt-6">
            {order.status === "delivered" && (
              <Button variant="outline" size="sm">
                Leave a Review
              </Button>
            )}
            {order.status === "shipped" && (
              <Button variant="outline" size="sm">
                Track Package
              </Button>
            )}
            {(order.status === "delivered" || order.status === "shipped") && (
              <Button variant="outline" size="sm">
                Buy Again
              </Button>
            )}
            <Button variant="ghost" size="sm">
              View Invoice
            </Button>
          </div>
        </div>
      )}
    </div>
  )
}

export default function OrdersPage() {
  return (
    <div className="flex min-h-screen flex-col bg-background pt-18.75">
      {/* <Header /> */}

      <main className="flex-1">
        <div className="mx-auto max-w-4xl px-4 py-8 sm:px-6 lg:px-8">
          <div className="flex items-center justify-between">
            <div>
              <h1 className="text-3xl font-bold tracking-tight text-foreground sm:text-4xl" style={{ fontFamily: 'var(--font-heading)' }}>
                Order History
              </h1>
              <p className="mt-2 text-muted-foreground">
                Track and manage your orders
              </p>
            </div>
            <Button asChild variant="outline">
              <Link to="/profile">
                View Profile
              </Link>
            </Button>
          </div>

          {orders.length > 0 ? (
            <div className="mt-8 space-y-4">
              {orders.map((order) => (
                <OrderCard key={order.id} order={order} />
              ))}
            </div>
          ) : (
            <div className="mt-16 text-center">
              <div className="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-muted">
                <Package className="h-10 w-10 text-muted-foreground" />
              </div>
              <h2 className="mt-6 text-xl font-semibold text-foreground">No orders yet</h2>
              <p className="mt-2 text-muted-foreground">
                When you place an order, it will appear here.
              </p>
              <Button asChild className="mt-6">
                <Link to="/shop">Start Shopping</Link>
              </Button>
            </div>
          )}
        </div>
      </main>

      {/* <Footer /> */}
    </div>
  )
}
