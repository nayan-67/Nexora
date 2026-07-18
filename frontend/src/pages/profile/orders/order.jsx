import { useEffect, useState } from "react"
import { Package, ChevronRight, Truck, CheckCircle2, Clock, XCircle, Calendar, AlertCircle, Filter, X, ArrowUpDown } from "lucide-react"
import { Button } from "@/components/lightswind/button"
import { cn } from "@/lib/utils"
import { Link } from "react-router-dom"
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

// Helper function to get delivery message
function getDeliveryMessage(item) {
  if (Number(item.status) === 3) {
    return {
      text: `Delivered on ${item.deliveredOn}`,
      subtext: "Your item has been delivered",
      icon: CheckCircle2,
      color: "text-green-600",
      bg: "bg-green-50",
    }
  } else if (Number(item.status) === 2) {
    return {
      text: "Will deliver by April 5, 2026",
      subtext: "Your item is on its way",
      icon: Truck,
      color: "text-blue-600",
      bg: "bg-blue-50",
    }
  } else if (Number(item.status) === 1) {
    return {
      text: "Will deliver by April 3, 2026",
      subtext: "Your item is being processed",
      icon: Clock,
      color: "text-amber-600",
      bg: "bg-amber-50",
    }
  } else {
    return {
      text: "Cancelled",
      subtext: "This item was cancelled",
      icon: XCircle,
      color: "text-red-600",
      bg: "bg-red-50",
    }
  }
}

// Flatten all items from all orders
// function getAllItems() {
//   const [orderItems, setOrderItems] = useState([])
//   // const orderItems = []
//   // orders.forEach((order) => {
//   //   order.items.forEach((item) => {
//   //     orderItems.push({
//   //       ...item,
//   //       orderId: order.id,
//   //       orderDate: order.date,
//   //     })
//   //   })
//   // })
//   useEffect(() => {
//     let active = true
//     api.get("/orderproducts")
//       .then((res) => {
//         if (active) {
//           setOrderItems(res.data)
//           console.log(res.data)
//         }
//       })
//       .catch((err) => {
//         console.error(err);
//       })
//     return () => { active = false }
//   }, [])
//   // Sort by status (processing first, then shipped, then delivered)
//   // const statusOrder = { processing: 0, shipped: 1, delivered: 2, cancelled: 3 }
//   // return orderItems.sort((a, b) => statusOrder[a.status] - statusOrder[b.status])
//   return orderItems
// }

function ItemCard({ item, products, variants }) {
  const [isExpanded, setIsExpanded] = useState(false)
  const deliveryInfo = getDeliveryMessage(item)
  const Icon = deliveryInfo.icon
  const orderDate = item.created_at
    ? new Date(item.created_at).toLocaleString("en-US", { month: "long", day: '2-digit', year: "numeric" })
    : null
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
    <Link to={`/orders/${item.order_id}`}>
      <div className="overflow-hidden rounded-2xl border border-border/40 bg-card transition-all duration-300 hover:border-primary/40 hover:shadow-lg hover:shadow-primary/5 cursor-pointer mb-3">
        {/* Item Header */}
        <div className="p-5 sm:p-6">
          <div className="flex items-start justify-between gap-4">
            {/* Image & Info */}
            <div className="flex items-start gap-4 flex-1">
              <div className="h-20 w-20 overflow-hidden rounded-xl bg-muted shrink-0">
                <img src={`${apiBase}/uploads/${imageType}_sm_${displayData?.featured_image}`} alt={prdDetails?.name} className="h-full w-full object-cover" />
              </div>
              <div className="flex-1 min-w-0">
                <h3 className="font-semibold text-foreground line-clamp-2">{prdDetails?.name} {name.length != 0 ? `(${name.join(',')})` : ''}</h3>
                <p className="mt-1 text-sm text-muted-foreground">
                  {orderDate}
                </p>
                <div className="mt-2 flex items-center gap-2 text-sm">
                  <span className="font-medium text-foreground">Qty: {item.quantity}</span>
                  <span className="text-muted-foreground">•</span>
                  <span className="text-foreground font-medium">${item.price * item.quantity}</span>
                </div>
              </div>
            </div>

            {/* Price & Chevron */}
            <div className="flex items-center gap-3 shrink-0">
              {/* <div className="text-right">
                <p className="text-lg font-bold text-foreground">${item.price * item.quantity}</p>
              </div> */}
              <ChevronRight className="h-5 w-5 text-muted-foreground" />
            </div>
          </div>

          {/* Delivery Status */}
          <div className={cn("mt-4 rounded-xl p-4", deliveryInfo.bg)}>
            <div className="flex items-start gap-3">
              <Icon className={cn("h-5 w-5 shrink-0 mt-0.5", deliveryInfo.color)} />
              <div>
                <p className={cn("font-semibold text-sm", deliveryInfo.color)}>
                  {deliveryInfo.text}
                </p>
                <p className={cn("text-xs mt-1", deliveryInfo.color === "text-green-600" ? "text-green-600/70" : deliveryInfo.color === "text-blue-600" ? "text-blue-600/70" : deliveryInfo.color === "text-amber-600" ? "text-amber-600/70" : "text-red-600/70")}>
                  {deliveryInfo.subtext}
                </p>
              </div>
            </div>
          </div>

          {/* SKU & Quick Actions */}
          {/* <div className="mt-4 flex flex-wrap items-center justify-between gap-3 border-t border-border/40 pt-4">
            <p className="text-xs text-muted-foreground">
              <span className="font-medium">SKU:</span> {item.sku || `NX-${item.id}`}
            </p>
            <div className="flex gap-2">
              {item.status === "delivered" && (
                <Button size="sm" variant="outline" className="text-xs">
                  Return
                </Button>
              )}
              {(item.status === "shipped" || item.status === "processing") && (
                <Button size="sm" variant="outline" className="text-xs">
                  View Details
                </Button>
              )}
              <Button size="sm" className="text-xs bg-primary hover:bg-primary/90">
                Open Order
              </Button>
            </div>
          </div> */}
        </div>
      </div>
    </Link>
  )
}

export default function OrdersPage() {
  // const orderItems = getAllItems()
  const [selectedFilter, setSelectedFilter] = useState("all")
  const [selectedSort, setSelectedSort] = useState("recent")
  const [orderItems, setOrderItems] = useState([])
  const [products, setProducts] = useState([])
  const [variants, setVariants] = useState([])

  useEffect(() => {
    let active = true;

    const loadOrdPrdData = async () => {
      try {
        const [OrdItemResponse, variantResponse, productResponse] = await Promise.all([
          api.get("/orderproducts"),
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

  const filterOptions = [
    { value: "all", label: "All Items", count: orderItems.length },
    { value: 1, label: "Processing", count: orderItems.filter(item => Number(item.status) === 1).length },
    { value: 2, label: "Shipped", count: orderItems.filter(item => Number(item.status) === 2).length },
    { value: 3, label: "Delivered", count: orderItems.filter(item => Number(item.status) === 3).length },
    { value: 0, label: "Cancelled", count: orderItems.filter(item => Number(item.status) === 0).length },
  ]

  const sortOptions = [
    { value: "recent", label: "Most Recent", icon: "↓" },
    { value: "oldest", label: "Oldest First", icon: "↑" },
    { value: "price-high", label: "Price: High to Low", icon: "↓" },
    { value: "price-low", label: "Price: Low to High", icon: "↑" },
  ]

  let filteredItems = selectedFilter === "all"
    ? orderItems
    : orderItems.filter(item => Number(item.status) === selectedFilter)

  // Apply sorting
  if (selectedSort === "recent") {
    filteredItems = [...filteredItems].sort((a, b) => new Date(b.orderDate) - new Date(a.orderDate))
  } else if (selectedSort === "oldest") {
    filteredItems = [...filteredItems].sort((a, b) => new Date(a.orderDate) - new Date(b.orderDate))
  } else if (selectedSort === "price-high") {
    filteredItems = [...filteredItems].sort((a, b) => (b.price * b.quantity) - (a.price * a.quantity))
  } else if (selectedSort === "price-low") {
    filteredItems = [...filteredItems].sort((a, b) => (a.price * a.quantity) - (b.price * b.quantity))
  }

  return (
    <div className="flex min-h-screen flex-col bg-background pt-22">
      <main className="flex-1">
        <div className="mx-auto max-w-5xl px-4 py-8 sm:px-6 lg:px-8">
          <div className="flex flex-col gap-6 sm:flex-row sm:items-end sm:justify-between">
            <div>
              <div className="flex items-center gap-3 mb-3">
                <div className="inline-flex h-10 w-10 items-center justify-center rounded-full bg-primary/10">
                  <Package className="h-6 w-6 text-primary" />
                </div>
                <h1 className="text-3xl font-bold tracking-tight text-foreground sm:text-4xl" style={{ fontFamily: 'var(--font-heading)' }}>
                  Order Items
                </h1>
              </div>
              <p className="mt-2 text-muted-foreground">
                Track {filteredItems.length} {filteredItems.length === 1 ? "item" : "items"} from your orders
              </p>
            </div>
            <Button asChild variant="custom" className="w-fit">
              <Link to={"/profile"}>
                View Profile
              </Link>
            </Button>
          </div>

          {/* Filter & Sort Section */}
          <div className="mt-8 mb-8 space-y-5">
            {/* Filter Tabs */}
            <div>
              <div className="flex items-center gap-2 mb-3">
                <Filter className="h-5 w-5 text-muted-foreground" />
                <p className="text-sm font-medium text-muted-foreground uppercase tracking-wide">Filter by Status</p>
              </div>
              <div className="flex flex-wrap gap-2">
                {filterOptions.map((option) => (
                  <button
                    key={option.value}
                    onClick={() => setSelectedFilter(option.value)}
                    className={cn(
                      "inline-flex items-center gap-2 rounded-full px-4 py-2 transition-all duration-200 font-medium text-sm",
                      selectedFilter === option.value
                        ? "bg-primary text-primary-foreground shadow-md"
                        : "bg-muted text-muted-foreground hover:bg-muted/80 border border-border/40"
                    )}
                  >
                    {option.label}
                    <span className={cn(
                      "inline-flex items-center justify-center rounded-full w-5 h-5 text-xs font-bold",
                      selectedFilter === option.value
                        ? "bg-primary-foreground/20 text-primary-foreground"
                        : "bg-background/60 text-muted-foreground"
                    )}>
                      {option.count}
                    </span>
                  </button>
                ))}
              </div>
            </div>

            {/* Sort Options */}
            <div>
              <div className="flex items-center gap-2 mb-3">
                <ArrowUpDown className="h-5 w-5 text-muted-foreground" />
                <p className="text-sm font-medium text-muted-foreground uppercase tracking-wide">Sort by</p>
              </div>
              <div className="flex flex-wrap gap-2">
                {sortOptions.map((option) => (
                  <button
                    key={option.value}
                    onClick={() => setSelectedSort(option.value)}
                    className={cn(
                      "inline-flex items-center gap-2 rounded-full px-4 py-2 transition-all duration-200 font-medium text-sm",
                      selectedSort === option.value
                        ? "bg-emerald-100 text-emerald-700 shadow-md border border-emerald-300"
                        : "bg-muted text-muted-foreground hover:bg-muted/80 border border-border/40"
                    )}
                  >
                    <span>{option.icon}</span>
                    {option.label}
                  </button>
                ))}
              </div>
            </div>
          </div>

          {filteredItems.length > 0 ? (
            <div className="space-y-3">
              {filteredItems.map((item) => (
                <ItemCard key={`${item.orderId}-${item.id}`} item={item} products={products} variants={variants} />
              ))}
            </div>
          ) : (
            <div className="mt-16 text-center">
              <div className="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-muted">
                <Package className="h-10 w-10 text-muted-foreground" />
              </div>
              <h2 className="mt-6 text-xl font-semibold text-foreground">
                {orderItems.length === 0 ? "No items yet" : "No items with this status"}
              </h2>
              <p className="mt-2 text-muted-foreground">
                {orderItems.length === 0
                  ? "When you place an order, your items will appear here."
                  : "Try adjusting your filter to see more items."}
              </p>
              {orderItems.length === 0 && (
                <Button asChild varient="custom" className="mt-6">
                  <Link to={"/shop"}>Start Shopping</Link>
                </Button>
              )}
              {orderItems.length > 0 && selectedFilter !== "all" && (
                <Button
                  onClick={() => setSelectedFilter("all")}
                  className="mt-6"
                >
                  View All Items
                </Button>
              )}
            </div>
          )}
        </div>
      </main>
    </div>
  )
}
