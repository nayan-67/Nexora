import { useState } from 'react'
import { Link, useParams } from 'react-router-dom'
import { ChevronDown, Package, MapPin, CreditCard, X, Download, ArrowLeft, Copy, Check, Truck, CheckCircle2, Clock, Calendar, AlertCircle } from 'lucide-react'
import { Button } from "@/components/lightswind/button"
import { cn } from '@/lib/utils'

const orders = [
    {
        id: 'NX-8FK2JH',
        date: 'March 28, 2026',
        status: 'delivered',
        total: 922,
        subtotal: 733,
        tax: 68.67,
        shipping_fee: 120.33,
        items: [
            {
                id: 1,
                name: 'Premium Wireless Headphones',
                price: 299,
                image: 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=100&h=100&fit=crop&q=80',
                quantity: 1,
                sku: 'NX-WH-001',
                status: 'delivered',
                timeline: [
                    { status: 'processing', date: 'March 28, 2026', time: '2:30 PM', label: 'Order Placed' },
                    { status: 'shipped', date: 'March 29, 2026', time: '10:15 AM', label: 'Shipped' },
                    { status: 'delivered', date: 'March 30, 2026', time: '4:45 PM', label: 'Delivered' },
                ],
            },
            {
                id: 2,
                name: 'Minimalist Watch Collection',
                price: 189,
                image: 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=100&h=100&fit=crop&q=80',
                quantity: 2,
                sku: 'NX-WT-002',
                status: 'delivered',
                timeline: [
                    { status: 'processing', date: 'March 28, 2026', time: '2:30 PM', label: 'Order Placed' },
                    { status: 'shipped', date: 'March 29, 2026', time: '10:15 AM', label: 'Shipped' },
                    { status: 'delivered', date: 'March 30, 2026', time: '4:45 PM', label: 'Delivered' },
                ],
            },
            {
                id: 5,
                name: 'Leather Crossbody Bag',
                price: 245,
                image: 'https://images.unsplash.com/photo-1548036328-c9fa89d128fa?w=100&h=100&fit=crop&q=80',
                quantity: 1,
                sku: 'NX-BG-005',
                status: 'shipped',
                timeline: [
                    { status: 'processing', date: 'March 28, 2026', time: '2:30 PM', label: 'Order Placed' },
                    { status: 'shipped', date: 'March 29, 2026', time: '10:15 AM', label: 'Shipped' },
                    { status: 'delivered', date: null, time: null, label: 'Arriving Soon' },
                ],
            },
        ],
        billing: {
            name: 'John Doe',
            email: 'john@example.com',
            phone: '+1 (555) 123-4567',
            address: '123 Main Street, Apt 4B',
            city: 'San Francisco',
            state: 'CA',
            zip: '94102',
            country: 'United States',
        },
        shipping: {
            name: 'John Doe',
            address: '123 Main Street, Apt 4B',
            city: 'San Francisco',
            state: 'CA',
            zip: '94102',
            country: 'United States',
        },
        payment: {
            method: 'Credit Card',
            cardType: 'Visa',
            lastFour: '4242',
            expiry: '12/26',
        },
    },
]

export default function OrderDetailPage() {
    const params = useParams()
    const order = orders.find((o) => o.id === params.id)
    const [expandedItems, setExpandedItems] = useState({})
    const [expandedTimelines, setExpandedTimelines] = useState({})
    const [copiedOrderId, setCopiedOrderId] = useState(false)
    const [orderData, setOrderData] = useState([])
    const [products, setProducts] = useState([])
    const [variants, setVariants] = useState([])

    // useEffect(() => {
    //     let active = true;

    //     const loadOrderData = async () => {
    //         try {
    //             const [OrdDataResponse, variantResponse, productResponse] = await Promise.all([
    //                 api.get("/orderproducts"),
    //                 api.get("/product/variants"),
    //                 api.get("/products"),
    //             ])


    //             if (!active) return

    //             setOrderData(OrdDataResponse.status === 200 ? OrdDataResponse.data : [])
    //             setVariants(variantResponse.status === 200 ? variantResponse.data : [])
    //             setProducts(productResponse.status === 200 ? productResponse.data : [])
    //         } catch (error) {
    //             if (!active) return

    //             setOrderData([])
    //             setVariants([])
    //             setProducts([])
    //             console.error("Error fetching data:", error)
    //         }
    //     }

    //     loadOrderData()

    //     return () => {
    //         active = false;
    //     };
    // }, []);



    if (!order) {
        return (
            <div className="flex min-h-screen flex-col bg-background">
                <main className="flex-1">
                    <div className="mx-auto max-w-4xl px-4 py-8 sm:px-6 lg:px-8 text-center">
                        <h1 className="text-2xl font-bold text-foreground">Order not found</h1>
                        <Button asChild className="mt-6">
                            <Link to="/orders">Back to Orders</Link>
                        </Button>
                    </div>
                </main>
            </div>
        )
    }

    const toggleItem = (itemId) => {
        setExpandedItems((prev) => ({
            ...prev,
            [itemId]: !prev[itemId],
        }))
    }

    const toggleTimeline = (itemId) => {
        setExpandedTimelines((prev) => ({
            ...prev,
            [itemId]: !prev[itemId],
        }))
    }

    const handleCopyOrderId = () => {
        navigator.clipboard.writeText(order.id)
        setCopiedOrderId(true)
        setTimeout(() => setCopiedOrderId(false), 2000)
    }

    const getStatusIcon = (status) => {
        switch (status) {
            case 'delivered':
                return <CheckCircle2 className="h-5 w-5" />
            case 'shipped':
                return <Truck className="h-5 w-5" />
            case 'processing':
                return <Clock className="h-5 w-5" />
            default:
                return <AlertCircle className="h-5 w-5" />
        }
    }

    const getStatusStyle = (status) => {
        switch (status) {
            case 'delivered':
                return { bg: 'bg-emerald-50', border: 'border-emerald-200', text: 'text-emerald-700', badge: 'bg-emerald-100', icon: 'text-emerald-600' }
            case 'shipped':
                return { bg: 'bg-blue-50', border: 'border-blue-200', text: 'text-blue-700', badge: 'bg-blue-100', icon: 'text-blue-600' }
            case 'processing':
                return { bg: 'bg-amber-50', border: 'border-amber-200', text: 'text-amber-700', badge: 'bg-amber-100', icon: 'text-amber-600' }
            default:
                return { bg: 'bg-gray-50', border: 'border-gray-200', text: 'text-gray-700', badge: 'bg-gray-100', icon: 'text-gray-600' }
        }
    }

    const formatStatusLabel = (status) => {
        return status.charAt(0).toUpperCase() + status.slice(1)
    }

    return (
        <div className="flex min-h-screen flex-col bg-linear-to-br from-slate-50 to-slate-100 dark:from-slate-950 dark:to-slate-900 pt-18.75">
            <main className="flex-1">
                <div className="mx-auto max-w-6xl px-4 py-8 sm:px-6 lg:px-8">
                    {/* Header */}
                    <div className="flex items-center gap-4 mb-8">
                        <Button variant="ghost" size="icon" asChild className="hover:bg-white dark:hover:bg-slate-800">
                            <Link to="/orders">
                                <ArrowLeft className="h-5 w-5" />
                            </Link>
                        </Button>
                        <div>
                            <h1 className="text-3xl font-bold text-foreground" style={{ fontFamily: 'var(--font-heading)' }}>
                                Order Details
                            </h1>
                        </div>
                    </div>

                    {/* Order Status Header */}
                    <div className="mb-8 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 p-6 sm:p-8 shadow-sm">
                        <div className="flex flex-col gap-6 sm:flex-row sm:items-start sm:justify-between">
                            <div className="flex-1">
                                <p className="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-3">Order Number</p>
                                <div className="flex items-center gap-3 mb-4">
                                    <p className="font-mono text-xl sm:text-2xl font-bold text-foreground">{order.id}</p>
                                    <button
                                        onClick={handleCopyOrderId}
                                        className="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 transition-all hover:bg-slate-200 dark:hover:bg-slate-700"
                                    >
                                        {copiedOrderId ? (
                                            <Check className="h-4 w-4 text-emerald-600" />
                                        ) : (
                                            <Copy className="h-4 w-4 text-slate-600 dark:text-slate-400" />
                                        )}
                                    </button>
                                </div>
                                <p className="text-sm text-slate-600 dark:text-slate-400 flex items-center gap-2">
                                    <Calendar className="h-4 w-4" />
                                    {order.date}
                                </p>
                            </div>
                            <div className="sm:text-right">
                                <p className="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-3">Order Status</p>
                                <div className={cn(
                                    'inline-flex items-center gap-2 rounded-full px-4 py-2.5 border font-semibold text-sm',
                                    getStatusStyle(order.status).bg,
                                    getStatusStyle(order.status).border,
                                    getStatusStyle(order.status).text
                                )}>
                                    <span className={getStatusStyle(order.status).icon}>
                                        {getStatusIcon(order.status)}
                                    </span>
                                    {formatStatusLabel(order.status)}
                                </div>
                            </div>
                        </div>
                    </div>

                    {/* Order Items Section */}
                    <div className="mb-8">
                        <div className="mb-6">
                            <h2 className="text-2xl font-bold text-foreground" style={{ fontFamily: 'var(--font-heading)' }}>
                                Order Items
                            </h2>
                            <p className="text-slate-600 dark:text-slate-400 text-sm mt-2">Track and manage your items</p>
                        </div>
                        <div className="space-y-4">
                            {order.items.map((item) => {
                                const itemStatus = getStatusStyle(item.status)
                                return (
                                    <div
                                        key={item.id}
                                        className="group overflow-hidden rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 transition-all duration-300 hover:border-slate-300 dark:hover:border-slate-600 hover:shadow-md"
                                    >
                                        {/* Item Header */}
                                        <button
                                            onClick={() => toggleItem(item.id)}
                                            className="w-full p-5 sm:p-6 flex items-center justify-between hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors"
                                        >
                                            <div className="flex items-center gap-4 flex-1 min-w-0">
                                                <div className="h-24 w-24 rounded-xl overflow-hidden bg-slate-100 dark:bg-slate-800 shrink-0 border border-slate-200 dark:border-slate-700 shadow-sm">
                                                    <img src={item.image} alt={item.name} className="h-full w-full object-cover" />
                                                </div>
                                                <div className="text-left min-w-0 flex-1">
                                                    <p className="font-semibold text-foreground line-clamp-2 text-sm sm:text-base">{item.name}</p>
                                                    <div className="mt-3 flex flex-wrap items-center gap-2">
                                                        <span className={cn(
                                                            'inline-flex items-center gap-1.5 rounded-full px-3 py-1.5 text-xs sm:text-sm border font-medium',
                                                            itemStatus.bg,
                                                            itemStatus.border,
                                                            itemStatus.text
                                                        )}>
                                                            <span className={itemStatus.icon}>{getStatusIcon(item.status)}</span>
                                                            {formatStatusLabel(item.status)}
                                                        </span>
                                                        <span className="inline-flex items-center gap-1.5 rounded-full bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 px-3 py-1.5 text-xs sm:text-sm font-medium text-slate-700 dark:text-slate-300">
                                                            <span className="text-slate-500 dark:text-slate-400">SKU:</span>
                                                            <span className="font-mono text-slate-600 dark:text-slate-300">{item.sku}</span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div className="flex items-center gap-4 shrink-0 ml-4">
                                                <div className="text-right">
                                                    <div className="flex items-baseline gap-1">
                                                        <p className="text-xl sm:text-2xl font-bold text-foreground">${item.price * item.quantity}</p>
                                                    </div>
                                                    <p className="text-xs text-slate-600 dark:text-slate-400 mt-1">
                                                        ${item.price} × {item.quantity}
                                                    </p>
                                                </div>
                                                <ChevronDown
                                                    className={cn(
                                                        'h-5 w-5 text-slate-400 transition-transform group-hover:text-foreground',
                                                        expandedItems[item.id] && 'rotate-180'
                                                    )}
                                                />
                                            </div>
                                        </button>

                                        {/* Item Details - Timeline & Actions */}
                                        {expandedItems[item.id] && (
                                            <div className="border-t border-slate-200 dark:border-slate-700 p-6 sm:p-8 space-y-6 bg-slate-50 dark:bg-slate-800/50">
                                                {/* Item Info Grid */}
                                                <div className="grid gap-4 sm:grid-cols-3">
                                                    <div className="rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 p-4">
                                                        <p className="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wide">Unit Price</p>
                                                        <p className="mt-2 text-2xl font-bold text-foreground">${item.price}</p>
                                                    </div>
                                                    <div className="rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 p-4">
                                                        <p className="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wide">Quantity</p>
                                                        <p className="mt-2 text-2xl font-bold text-foreground">{item.quantity}</p>
                                                    </div>
                                                    <div className="rounded-xl bg-linear-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-900/10 border border-blue-200 dark:border-blue-800 p-4">
                                                        <p className="text-xs font-bold text-blue-600 dark:text-blue-400 uppercase tracking-wide">Total</p>
                                                        <p className="mt-2 text-2xl font-bold text-blue-700 dark:text-blue-300">${item.price * item.quantity}</p>
                                                    </div>
                                                </div>

                                                {/* Status Timeline - Minimal */}
                                                <div className="border-t border-slate-200 dark:border-slate-700 pt-6">
                                                    {/* Minimal Timeline View */}
                                                    {!expandedTimelines[item.id] ? (
                                                        <div>
                                                            <button
                                                                onClick={() => toggleTimeline(item.id)}
                                                                className="w-full hover:opacity-80 transition-opacity text-left"
                                                            >
                                                                <p className="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wide mb-4">Delivery Timeline</p>
                                                                <div className="flex items-center gap-2">
                                                                    {item.timeline.map((step, index) => {
                                                                        const isActive = step.status === item.status
                                                                        const isCompleted = item.timeline.slice(0, index + 1).some(s => s.status === item.status)
                                                                        let dotColor = 'bg-slate-300 dark:bg-slate-600'

                                                                        if (isCompleted || isActive) {
                                                                            if (step.status === 'delivered') dotColor = 'bg-emerald-500'
                                                                            else if (step.status === 'shipped') dotColor = 'bg-blue-500'
                                                                            else if (step.status === 'processing') dotColor = 'bg-amber-500'
                                                                        }

                                                                        return (
                                                                            <div key={index} className="flex items-center flex-1">
                                                                                {/* Dot */}
                                                                                <div className={cn(
                                                                                    'shrink-0 w-7 h-7 rounded-full flex items-center justify-center transition-all',
                                                                                    isCompleted || isActive ? dotColor : 'bg-slate-200 dark:bg-slate-700',
                                                                                    isActive && 'ring-2 ring-offset-2 dark:ring-offset-slate-900'
                                                                                )}>
                                                                                    {isCompleted && !isActive ? (
                                                                                        <Check className="h-3.5 w-3.5 text-white" />
                                                                                    ) : isActive ? (
                                                                                        <div className="w-1.5 h-1.5 rounded-full bg-white animate-pulse" />
                                                                                    ) : (
                                                                                        <div className="w-1.5 h-1.5 rounded-full bg-slate-400 dark:bg-slate-500" />
                                                                                    )}
                                                                                </div>

                                                                                {/* Line */}
                                                                                {index < item.timeline.length - 1 && (
                                                                                    <div className={cn(
                                                                                        'flex-1 h-0.5 mx-1 transition-all',
                                                                                        isCompleted || isActive ? 'bg-slate-300 dark:bg-slate-600' : 'bg-slate-200 dark:bg-slate-700'
                                                                                    )} />
                                                                                )}
                                                                            </div>
                                                                        )
                                                                    })}
                                                                </div>

                                                                {/* Labels */}
                                                                <div className="flex gap-2 mt-3">
                                                                    {item.timeline.map((step, index) => (
                                                                        <div key={index} className="flex-1 text-center">
                                                                            <p className="text-xs font-medium text-foreground">{step.label}</p>
                                                                            {step.date && (
                                                                                <p className="text-xs text-slate-600 dark:text-slate-400 mt-0.5">
                                                                                    {step.time || 'TBD'}
                                                                                </p>
                                                                            )}
                                                                        </div>
                                                                    ))}
                                                                </div>

                                                                {/* Expand Button */}
                                                                <div className="flex justify-center mt-3">
                                                                    <span className="text-xs text-blue-600 dark:text-blue-400 font-medium flex items-center gap-1">
                                                                        View Details
                                                                        <ChevronDown className="h-3 w-3" />
                                                                    </span>
                                                                </div>
                                                            </button>
                                                        </div>
                                                    ) : (
                                                        <div>
                                                            {/* Detailed Vertical Timeline */}
                                                            <button
                                                                onClick={() => toggleTimeline(item.id)}
                                                                className="w-full flex items-center justify-between mb-4 hover:opacity-80 transition-opacity"
                                                            >
                                                                <p className="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wide">Delivery Timeline</p>
                                                                <ChevronDown className="h-5 w-5 text-slate-400 rotate-180" />
                                                            </button>

                                                            <div className="relative pl-8">
                                                                {/* Vertical Line */}
                                                                <div className="absolute left-3 top-0 bottom-0 w-0.5 bg-linear-to-b from-slate-300 to-slate-200 dark:from-slate-600 dark:to-slate-700" />

                                                                <div className="space-y-6">
                                                                    {item.timeline.map((step, index) => {
                                                                        const isActive = step.status === item.status
                                                                        let stepBg = 'bg-amber-50 dark:bg-amber-900/20'
                                                                        let stepBorder = 'border-amber-200 dark:border-amber-800'
                                                                        let stepTextColor = 'text-amber-700 dark:text-amber-400'
                                                                        let stepDotBg = 'bg-amber-100 dark:bg-amber-900/50'
                                                                        let stepDotText = 'text-amber-600 dark:text-amber-400'

                                                                        if (step.status === 'delivered') {
                                                                            stepBg = 'bg-emerald-50 dark:bg-emerald-900/20'
                                                                            stepBorder = 'border-emerald-200 dark:border-emerald-800'
                                                                            stepTextColor = 'text-emerald-700 dark:text-emerald-400'
                                                                            stepDotBg = 'bg-emerald-100 dark:bg-emerald-900/50'
                                                                            stepDotText = 'text-emerald-600 dark:text-emerald-400'
                                                                        } else if (step.status === 'shipped') {
                                                                            stepBg = 'bg-blue-50 dark:bg-blue-900/20'
                                                                            stepBorder = 'border-blue-200 dark:border-blue-800'
                                                                            stepTextColor = 'text-blue-700 dark:text-blue-400'
                                                                            stepDotBg = 'bg-blue-100 dark:bg-blue-900/50'
                                                                            stepDotText = 'text-blue-600 dark:text-blue-400'
                                                                        }

                                                                        return (
                                                                            <div key={index} className="relative">
                                                                                {/* Timeline Dot */}
                                                                                <div className={cn(
                                                                                    'absolute -left-5 top-1 flex h-10 w-10 items-center justify-center rounded-full border-4 border-white dark:border-slate-900 transition-all',
                                                                                    isActive ? stepDotBg : 'bg-slate-100 dark:bg-slate-800'
                                                                                )}>
                                                                                    {isActive ? (
                                                                                        <Clock className={cn('h-4 w-4', stepDotText)} />
                                                                                    ) : (
                                                                                        <Check className={cn('h-4 w-4', isActive ? stepDotText : 'text-slate-400')} />
                                                                                    )}
                                                                                </div>

                                                                                {/* Step Content */}
                                                                                <div className={cn(
                                                                                    'rounded-lg p-4 border-2 transition-all',
                                                                                    isActive ? `${stepBg} ${stepBorder} shadow-sm` : 'bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700'
                                                                                )}>
                                                                                    <div className="flex items-start justify-between gap-4">
                                                                                        <div>
                                                                                            <p className={cn(
                                                                                                'font-bold text-sm',
                                                                                                isActive ? stepTextColor : 'text-foreground'
                                                                                            )}>
                                                                                                {step.label}
                                                                                            </p>
                                                                                            {step.date && step.time ? (
                                                                                                <p className={cn(
                                                                                                    'text-xs mt-2',
                                                                                                    isActive ? stepTextColor : 'text-slate-600 dark:text-slate-400'
                                                                                                )}>
                                                                                                    <span className="font-semibold">{step.date}</span> at <span className="font-semibold">{step.time}</span>
                                                                                                </p>
                                                                                            ) : (
                                                                                                <p className="text-xs text-slate-600 dark:text-slate-400 mt-2 italic">Expected delivery</p>
                                                                                            )}
                                                                                        </div>
                                                                                        {isActive && (
                                                                                            <span className={cn(
                                                                                                'inline-flex shrink-0 items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-semibold whitespace-nowrap',
                                                                                                stepDotBg,
                                                                                                stepDotText
                                                                                            )}>
                                                                                                <div className="h-1.5 w-1.5 rounded-full animate-pulse" style={{ backgroundColor: 'currentColor' }} />
                                                                                                Current
                                                                                            </span>
                                                                                        )}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        )
                                                                    })}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    )}
                                                </div>

                                                {/* Action Buttons */}
                                                <div className="flex flex-wrap gap-3 border-t border-slate-200 dark:border-slate-700 pt-6">
                                                    <Button asChild size="sm" variant="outline" className="flex-1">
                                                        <Link to={`/products/${item.id}`}>View Product</Link>
                                                    </Button>
                                                    {item.status === 'processing' || item.status === 'shipped' ? (
                                                        <Button asChild size="sm" className="flex-1 bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-900/30 border border-red-200 dark:border-red-800">
                                                            <Link to={`/orders/${order.id}/cancel?item=${item.id}`}>
                                                                Cancel Item
                                                            </Link>
                                                        </Button>
                                                    ) : item.status === 'delivered' ? (
                                                        <Button asChild size="sm" className="flex-1 bg-blue-600 hover:bg-blue-700 text-white">
                                                            <Link to={`/orders/${order.id}/return?item=${item.id}`}>
                                                                Return Item
                                                            </Link>
                                                        </Button>
                                                    ) : null}
                                                </div>
                                            </div>
                                        )}
                                    </div>
                                )
                            })}
                        </div>
                    </div>

                    {/* Two Column Layout for Addresses */}
                    <div className="grid gap-6 lg:grid-cols-2 mb-8">
                        {/* Billing Address */}
                        <div className="rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 p-6 shadow-sm hover:shadow-md transition-shadow">
                            <div className="flex items-center gap-3 mb-5">
                                <div className="p-2.5 bg-blue-50 dark:bg-blue-900/30 rounded-lg">
                                    <MapPin className="h-5 w-5 text-blue-600 dark:text-blue-400" />
                                </div>
                                <h3 className="font-semibold text-foreground text-lg" style={{ fontFamily: 'var(--font-heading)' }}>
                                    Billing Address
                                </h3>
                            </div>
                            <div className="space-y-2 text-sm">
                                <p className="font-medium text-foreground">{order.billing.name}</p>
                                <p className="text-slate-600 dark:text-slate-400">{order.billing.address}</p>
                                <p className="text-slate-600 dark:text-slate-400">
                                    {order.billing.city}, {order.billing.state} {order.billing.zip}
                                </p>
                                <p className="text-slate-600 dark:text-slate-400">{order.billing.country}</p>
                                <div className="pt-3 border-t border-slate-200 dark:border-slate-700 mt-3">
                                    <p className="text-slate-600 dark:text-slate-400">{order.billing.phone}</p>
                                    <p className="text-slate-600 dark:text-slate-400">{order.billing.email}</p>
                                </div>
                            </div>
                        </div>

                        {/* Shipping Address */}
                        <div className="rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 p-6 shadow-sm hover:shadow-md transition-shadow">
                            <div className="flex items-center gap-3 mb-5">
                                <div className="p-2.5 bg-emerald-50 dark:bg-emerald-900/30 rounded-lg">
                                    <Package className="h-5 w-5 text-emerald-600 dark:text-emerald-400" />
                                </div>
                                <h3 className="font-semibold text-foreground text-lg" style={{ fontFamily: 'var(--font-heading)' }}>
                                    Shipping Address
                                </h3>
                            </div>
                            <div className="space-y-2 text-sm">
                                <p className="font-medium text-foreground">{order.shipping.name}</p>
                                <p className="text-slate-600 dark:text-slate-400">{order.shipping.address}</p>
                                <p className="text-slate-600 dark:text-slate-400">
                                    {order.shipping.city}, {order.shipping.state} {order.shipping.zip}
                                </p>
                                <p className="text-slate-600 dark:text-slate-400">{order.shipping.country}</p>
                            </div>
                        </div>
                    </div>

                    {/* Payment Information */}
                    <div className="mb-8">
                        <div className="rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 p-6 shadow-sm">
                            <div className="flex items-center gap-3 mb-5">
                                <div className="p-2.5 bg-purple-50 dark:bg-purple-900/30 rounded-lg">
                                    <CreditCard className="h-5 w-5 text-purple-600 dark:text-purple-400" />
                                </div>
                                <h3 className="font-semibold text-foreground text-lg" style={{ fontFamily: 'var(--font-heading)' }}>
                                    Payment Method
                                </h3>
                            </div>
                            <div className="grid gap-4 sm:grid-cols-3">
                                <div>
                                    <p className="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wide mb-2">Method</p>
                                    <p className="text-foreground font-medium">{order.payment.method}</p>
                                </div>
                                <div>
                                    <p className="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wide mb-2">Card</p>
                                    <p className="text-foreground font-medium font-mono">
                                        {order.payment.cardType} •••• {order.payment.lastFour}
                                    </p>
                                </div>
                                <div>
                                    <p className="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wide mb-2">Expires</p>
                                    <p className="text-foreground font-medium">{order.payment.expiry}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {/* Order Summary */}
                    <div className="rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 p-6 sm:p-8 shadow-sm">
                        <h3 className="mb-6 text-xl font-bold text-foreground" style={{ fontFamily: 'var(--font-heading)' }}>
                            Order Summary
                        </h3>

                        {/* Summary Details */}
                        <div className="space-y-3 mb-6 pb-6 border-b border-slate-200 dark:border-slate-700">
                            <div className="flex justify-between items-center">
                                <p className="text-slate-600 dark:text-slate-400 font-medium">Subtotal</p>
                                <p className="text-foreground font-semibold">${order.subtotal.toFixed(2)}</p>
                            </div>
                            <div className="flex justify-between items-center">
                                <p className="text-slate-600 dark:text-slate-400 font-medium">Shipping</p>
                                <p className="text-foreground font-semibold">${order.shipping_fee.toFixed(2)}</p>
                            </div>
                            <div className="flex justify-between items-center">
                                <p className="text-slate-600 dark:text-slate-400 font-medium">Tax</p>
                                <p className="text-foreground font-semibold">${order.tax.toFixed(2)}</p>
                            </div>
                        </div>

                        {/* Total */}
                        <div className="flex justify-between items-center mb-8 p-4 bg-linear-to-r from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-900/10 rounded-xl border border-blue-200 dark:border-blue-800">
                            <p className="text-lg font-bold text-foreground">Order Total</p>
                            <p className="text-3xl font-bold text-blue-600 dark:text-blue-400">${order.total.toFixed(2)}</p>
                        </div>

                        {/* Action Buttons */}
                        <div className="flex flex-col sm:flex-row gap-3 border-t border-slate-200 dark:border-slate-700 pt-6">
                            <Button className="flex-1 gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold">
                                <Download className="h-4 w-4" />
                                Download Invoice
                            </Button>
                            <Button className="flex-1 gap-2 border border-red-300 dark:border-red-700 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 font-semibold">
                                <X className="h-4 w-4" />
                                Cancel Order
                            </Button>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    )
}
