import { useState } from 'react'
import { ChevronDown, Package, MapPin, CreditCard, X, Download, ArrowLeft } from 'lucide-react'
import { Button } from '@/components/ui/button'
import { cn } from '@/lib/utils'
import { Link, useParams } from 'react-router-dom'

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
                deliveredOn: 'March 30, 2026',
            },
            {
                id: 2,
                name: 'Minimalist Watch Collection',
                price: 189,
                image: 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=100&h=100&fit=crop&q=80',
                quantity: 2,
                sku: 'NX-WT-002',
                status: 'delivered',
                deliveredOn: 'March 30, 2026',
            },
            {
                id: 5,
                name: 'Leather Crossbody Bag',
                price: 245,
                image: 'https://images.unsplash.com/photo-1548036328-c9fa89d128fa?w=100&h=100&fit=crop&q=80',
                quantity: 1,
                sku: 'NX-BG-005',
                status: 'delivered',
                deliveredOn: 'March 29, 2026',
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

const statusColors = {
    delivered: { bg: 'bg-green-100', text: 'text-green-700', badge: 'bg-green-50' },
    shipped: { bg: 'bg-blue-100', text: 'text-blue-700', badge: 'bg-blue-50' },
    processing: { bg: 'bg-amber-100', text: 'text-amber-700', badge: 'bg-amber-50' },
    cancelled: { bg: 'bg-red-100', text: 'text-red-700', badge: 'bg-red-50' },
}

export default function OrderDetailPage() {
    const params = useParams()
    const order = orders.find((o) => o.id === params.id)
    const [expandedItems, setExpandedItems] = useState({})

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

    return (
        <div className="flex min-h-screen flex-col bg-background">
            <main className="flex-1">
                <div className="mx-auto max-w-4xl px-4 py-8 sm:px-6 lg:px-8">
                    {/* Header */}
                    <div className="flex items-center gap-4 mb-8">
                        <Button variant="ghost" size="icon" asChild>
                            <Link to="/orders">
                                <ArrowLeft className="h-5 w-5" />
                            </Link>
                        </Button>
                        <div>
                            <h1 className="text-3xl font-bold text-foreground" style={{ fontFamily: 'var(--font-heading)' }}>
                                Order Details
                            </h1>
                            <p className="mt-1 text-muted-foreground">Order {order.id}</p>
                        </div>
                    </div>

                    {/* Order Info Bar */}
                    <div className="grid gap-4 sm:grid-cols-3 mb-8">
                        <div className="rounded-xl border border-border/60 bg-card p-4">
                            <p className="text-sm text-muted-foreground">Order Date</p>
                            <p className="mt-1 font-semibold text-foreground">{order.date}</p>
                        </div>
                        <div className="rounded-xl border border-border/60 bg-card p-4">
                            <p className="text-sm text-muted-foreground">Status</p>
                            <div className="mt-2 inline-flex items-center gap-2 rounded-full bg-green-50 px-3 py-1">
                                <div className="h-2 w-2 rounded-full bg-green-600" />
                                <p className="text-sm font-medium text-green-700">Delivered</p>
                            </div>
                        </div>
                        <div className="rounded-xl border border-border/60 bg-card p-4">
                            <p className="text-sm text-muted-foreground">Order Total</p>
                            <p className="mt-1 font-semibold text-foreground">${order.total}</p>
                        </div>
                    </div>

                    {/* Order Items Section */}
                    <div className="mb-8">
                        <h2 className="mb-4 text-xl font-bold text-foreground" style={{ fontFamily: 'var(--font-heading)' }}>
                            Order Items
                        </h2>
                        <div className="space-y-3">
                            {order.items.map((item) => (
                                <div key={item.id} className="rounded-xl border border-border/60 bg-card overflow-hidden">
                                    {/* Item Header */}
                                    <button
                                        onClick={() => toggleItem(item.id)}
                                        className="w-full p-4 flex items-center justify-between hover:bg-muted/50 transition-colors"
                                    >
                                        <div className="flex items-center gap-4 flex-1">
                                            <div className="h-16 w-16 rounded-lg overflow-hidden bg-muted flex-shrink-0">
                                                <img src={item.image} alt={item.name} className="h-full w-full object-cover" />
                                            </div>
                                            <div className="text-left">
                                                <p className="font-semibold text-foreground">{item.name}</p>
                                                <p className="text-sm text-muted-foreground">Qty: {item.quantity} × ${item.price}</p>
                                            </div>
                                        </div>
                                        <div className="flex items-center gap-4">
                                            <p className="font-semibold text-foreground">${item.price * item.quantity}</p>
                                            <ChevronDown
                                                className={cn(
                                                    'h-5 w-5 text-muted-foreground transition-transform',
                                                    expandedItems[item.id] && 'rotate-180'
                                                )}
                                            />
                                        </div>
                                    </button>

                                    {/* Item Details */}
                                    {expandedItems[item.id] && (
                                        <div className="border-t border-border/40 p-4 space-y-4">
                                            <div className="grid gap-4 sm:grid-cols-2">
                                                <div>
                                                    <p className="text-xs font-medium text-muted-foreground uppercase tracking-wide">SKU</p>
                                                    <p className="mt-1 font-mono text-sm text-foreground">{item.sku}</p>
                                                </div>
                                                <div>
                                                    <p className="text-xs font-medium text-muted-foreground uppercase tracking-wide">Price per Item</p>
                                                    <p className="mt-1 text-sm text-foreground">${item.price}</p>
                                                </div>
                                                <div>
                                                    <p className="text-xs font-medium text-muted-foreground uppercase tracking-wide">Quantity</p>
                                                    <p className="mt-1 text-sm text-foreground">{item.quantity}</p>
                                                </div>
                                                <div>
                                                    <p className="text-xs font-medium text-muted-foreground uppercase tracking-wide">Status</p>
                                                    <div className="mt-1 inline-flex items-center gap-1 rounded-full bg-green-50 px-2.5 py-1">
                                                        <div className="h-1.5 w-1.5 rounded-full bg-green-600" />
                                                        <p className="text-xs font-medium text-green-700">{item.status}</p>
                                                    </div>
                                                </div>
                                                {item.deliveredOn && (
                                                    <div className="sm:col-span-2">
                                                        <p className="text-xs font-medium text-muted-foreground uppercase tracking-wide">Delivered On</p>
                                                        <p className="mt-1 text-sm text-foreground">{item.deliveredOn}</p>
                                                    </div>
                                                )}
                                            </div>
                                            <div className="flex gap-2 pt-2 border-t border-border/40">
                                                <Button asChild size="sm" variant="outline" className="flex-1">
                                                    <Link to={`/products/${item.id}`}>View Product</Link>
                                                </Button>
                                                {order.status !== 'delivered' ? (
                                                    <Button asChild size="sm" variant="outline" className="flex-1 text-destructive hover:bg-destructive/10">
                                                        <Link to={`/orders/${order.id}/cancel?item=${item.id}`}>
                                                            Cancel Item
                                                        </Link>
                                                    </Button>
                                                ) : (
                                                    <Button asChild size="sm" variant="outline" className="flex-1">
                                                        <Link to={`/orders/return/${order.id}?item=${item.id}`}>
                                                            Return Item
                                                        </Link>
                                                    </Button>
                                                )}
                                            </div>
                                        </div>
                                    )}
                                </div>
                            ))}
                        </div>
                    </div>

                    {/* Billing & Shipping */}
                    <div className="grid gap-6 sm:grid-cols-2 mb-8">
                        {/* Billing Address */}
                        <div className="rounded-xl border border-border/60 bg-card p-6">
                            <div className="flex items-center gap-2 mb-4">
                                <MapPin className="h-5 w-5 text-primary" />
                                <h3 className="font-semibold text-foreground" style={{ fontFamily: 'var(--font-heading)' }}>
                                    Billing Address
                                </h3>
                            </div>
                            <div className="space-y-2 text-sm">
                                <p className="font-medium text-foreground">{order.billing.name}</p>
                                <p className="text-muted-foreground">{order.billing.address}</p>
                                <p className="text-muted-foreground">
                                    {order.billing.city}, {order.billing.state} {order.billing.zip}
                                </p>
                                <p className="text-muted-foreground">{order.billing.country}</p>
                                <p className="text-muted-foreground">{order.billing.phone}</p>
                                <p className="text-muted-foreground">{order.billing.email}</p>
                            </div>
                        </div>

                        {/* Shipping Address */}
                        <div className="rounded-xl border border-border/60 bg-card p-6">
                            <div className="flex items-center gap-2 mb-4">
                                <Package className="h-5 w-5 text-primary" />
                                <h3 className="font-semibold text-foreground" style={{ fontFamily: 'var(--font-heading)' }}>
                                    Shipping Address
                                </h3>
                            </div>
                            <div className="space-y-2 text-sm">
                                <p className="font-medium text-foreground">{order.shipping.name}</p>
                                <p className="text-muted-foreground">{order.shipping.address}</p>
                                <p className="text-muted-foreground">
                                    {order.shipping.city}, {order.shipping.state} {order.shipping.zip}
                                </p>
                                <p className="text-muted-foreground">{order.shipping.country}</p>
                            </div>
                        </div>
                    </div>

                    {/* Payment Information */}
                    <div className="mb-8">
                        <div className="rounded-xl border border-border/60 bg-card p-6">
                            <div className="flex items-center gap-2 mb-4">
                                <CreditCard className="h-5 w-5 text-primary" />
                                <h3 className="font-semibold text-foreground" style={{ fontFamily: 'var(--font-heading)' }}>
                                    Payment Method
                                </h3>
                            </div>
                            <div className="space-y-2 text-sm">
                                <p className="text-muted-foreground">Method: {order.payment.method}</p>
                                <p className="text-muted-foreground">
                                    {order.payment.cardType} ending in {order.payment.lastFour}
                                </p>
                                <p className="text-muted-foreground">Expires: {order.payment.expiry}</p>
                            </div>
                        </div>
                    </div>

                    {/* Order Summary & Invoice */}
                    <div className="rounded-xl border border-border/60 bg-card p-6">
                        <h3 className="mb-6 text-lg font-bold text-foreground" style={{ fontFamily: 'var(--font-heading)' }}>
                            Order Summary
                        </h3>

                        {/* Summary Details */}
                        <div className="space-y-3 mb-6 pb-6 border-b border-border/40">
                            <div className="flex justify-between">
                                <p className="text-muted-foreground">Subtotal</p>
                                <p className="text-foreground">${order.subtotal}</p>
                            </div>
                            <div className="flex justify-between">
                                <p className="text-muted-foreground">Shipping</p>
                                <p className="text-foreground">${order.shipping_fee}</p>
                            </div>
                            <div className="flex justify-between">
                                <p className="text-muted-foreground">Tax</p>
                                <p className="text-foreground">${order.tax}</p>
                            </div>
                        </div>

                        {/* Total */}
                        <div className="flex justify-between items-center mb-6">
                            <p className="text-lg font-bold text-foreground">Order Total</p>
                            <p className="text-2xl font-bold text-primary">${order.total}</p>
                        </div>

                        {/* Action Buttons */}
                        <div className="flex gap-3 border-t border-border/40 pt-6">
                            <Button className="flex-1 gap-2">
                                <Download className="h-4 w-4" />
                                Download Invoice
                            </Button>
                            <Button asChild variant="outline" className="flex-1 gap-2">
                                <Link to={`/orders/${order.id}/cancel`}>
                                    <X className="h-4 w-4" />
                                    Cancel Order
                                </Link>
                            </Button>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    )
}

