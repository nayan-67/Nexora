import { useEffect, useState } from "react"
import { Link } from "react-router-dom"
import { Package, ChevronRight, Truck, CheckCircle2, Clock, XCircle } from "lucide-react"
import { Button } from "@/components/ui/button"
import { cn } from "@/lib/utils"
import api from "@/lib/api"
import { toast } from "react-hot-toast"
const apiBase = api.defaults.baseURL.replace(/\/api\/?$/, "")

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
  3: {
    label: "Delivered",
    icon: CheckCircle2,
    color: "text-green-600",
    bg: "bg-green-100",
  },
  2: {
    label: "Shipped",
    icon: Truck,
    color: "text-blue-600",
    bg: "bg-blue-100",
  },
  1: {
    label: "Processing",
    icon: Clock,
    color: "text-amber-600",
    bg: "bg-amber-100",
  },
  0: {
    label: "Cancelled",
    icon: XCircle,
    color: "text-red-600",
    bg: "bg-red-100",
  },
}

function OrderCard({ order }) {
  const [isExpanded, setIsExpanded] = useState(false)
  const status = statusConfig[order.order_status]
  const StatusIcon = status.icon
  const [orderItems, setOrderItems] = useState([])
  const [products, setProducts] = useState([])
  const [variants, setVariants] = useState([])
  const orderDate = order.created_at
    ? new Date(order.created_at).toLocaleString("en-US", { month: "long", day: '2-digit', year: "numeric" })
    : null

  useEffect(() => {
    let active = true;

    const loadOrdPrdData = async () => {
      try {
        const [OrdItemResponse, variantResponse, productResponse] = await Promise.all([
          api.get(`/orderitems/${order.id}`),
          api.get("/product/variants"),
          api.get("/products"),
        ])

        if (!active) return

        setOrderItems(OrdItemResponse.status === 200 ? OrdItemResponse.data : [])
        setVariants(variantResponse.status === 200 ? variantResponse.data : [])
        setProducts(productResponse.status === 200 ? productResponse.data : [])
      } catch (error) {
        if (!active) return

        setOrderItems([])
        setVariants([])
        setProducts([])
        console.error("Error fetching data:", error)
      }
    }

    loadOrdPrdData()

    return () => {
      active = false;
    };
  }, []);

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
              <span className="font-mono font-semibold text-foreground">{order.order_number}</span>
              <span className={cn(
                "rounded-full px-2.5 py-0.5 text-xs font-medium",
                status.bg,
                status.color
              )}>
                {status.label}
              </span>
            </div>
            <p className="mt-1 text-sm text-muted-foreground">
              {orderDate} &bull; {orderItems.length} {orderItems.length === 1 ? "item" : "items"}
            </p>
          </div>
        </div>
        <div className="flex items-center gap-4">
          {/* <span className="text-lg font-semibold text-foreground">${order.total_price}</span> */}
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
            {orderItems.map((item) => {
              const isVariant = item.product_type == 2
              const prdDetails = products?.find((p) => Number(p.id) === Number(item.product_id))
              const variantDetails = isVariant && variants?.find((v) => v.sku == item.sku)
              const displayData = isVariant ? variantDetails : prdDetails
              const imageType = isVariant ? 'var' : 'prd'
              const attributes = variantDetails?.attributes
              const name = []
              if (attributes) {
                attributes.map(val => (
                  name.push(val.value.name || val.value)
                ))
              }
              return (
                <div key={item.id} className="flex items-center gap-4" >
                  <div className="h-16 w-16 overflow-hidden rounded-xl bg-muted">
                    <img src={`${apiBase}/uploads/${imageType}_sm_${displayData?.featured_image}`} alt={prdDetails?.name} className="h-full w-full object-cover text-xs" />
                  </div>
                  <div className="flex-1">
                    <Link
                      to={`/products/${item.product_id}`}
                      className="font-medium text-foreground transition-colors hover:text-primary"
                    >
                      {prdDetails.name} {name.length != 0 ? `(${name.join(',')})` : ''}
                    </Link>
                    <p className="text-sm text-muted-foreground">
                      Qty: {item.quantity} &bull; ${item.price}
                    </p>
                  </div>
                  <p className="font-medium text-foreground">
                    ${item.price * item.quantity}
                  </p>
                </div>
              )
            })}
          </div>

          {/* Actions */}
          <div className="mt-6 flex justify-end border-t border-border/40 pt-6">
            {/* <div className="flex flex-wrap gap-3">
              {Number(order.order_status) === 3 && (
                <Button variant="outline" size="sm">
                  Leave a Review
                </Button>
              )}
              {Number(order.order_status) === 2 && (
                <Button variant="outline" size="sm">
                  Track Package
                </Button>
              )}
              {(Number(order.order_status) === 3 || Number(order.order_status) === 2) && (
                <Button variant="outline" size="sm">
                  Buy Again
                </Button>
              )}
              <Button variant="ghost" size="sm">
                View Invoice
              </Button>
            </div> */}
            <Button>
              <Link to={`/orders/${order.id}`}>View Details</Link>
            </Button>
          </div>
        </div>
      )
      }
    </div >
  )
}

export default function OrdersPage() {

  const [orders, setOrders] = useState([])

  useEffect(() => {
    let active = true

    api.get("/userorders")
      .then((response) => {
        if (active) {
          setOrders(response.data)
        }
      })
      .catch((error) => {
        toast.error(error.response?.data?.message || "Failed to load orders.")
      })
      
    return () => { active = false }
  }, [])

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

          {orders.length != 0 ? (
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
