import { useState } from 'react'
import { ArrowLeft, AlertCircle, Check } from 'lucide-react'
import { Button } from '@/components/ui/button'
import { Link, useParams, useSearchParams } from 'react-router-dom'

const orders = [
    {
        id: 'NX-8FK2JH',
        date: 'March 28, 2026',
        status: 'delivered',
        total: 922,
        items: [
            {
                id: 1,
                name: 'Premium Wireless Headphones',
                price: 299,
                quantity: 1,
            },
            {
                id: 2,
                name: 'Minimalist Watch Collection',
                price: 189,
                quantity: 2,
            },
            {
                id: 5,
                name: 'Leather Crossbody Bag',
                price: 245,
                quantity: 1,
            },
        ],
    },
]

const cancellationReasons = [
    { value: 'wrong-item', label: 'Received wrong item' },
    { value: 'defective', label: 'Product is defective' },
    { value: 'not-as-described', label: 'Not as described' },
    { value: 'changed-mind', label: 'Changed my mind' },
    { value: 'found-cheaper', label: 'Found it cheaper elsewhere' },
    { value: 'no-longer-needed', label: 'No longer needed' },
    { value: 'other', label: 'Other reason' },
]

export default function CancelOrderPage() {
    const params = useParams()
    const [searchParams] = useSearchParams()
    const order = orders.find((o) => o.id === params.id)
    const itemId = searchParams.get('item')

    const [selectedReason, setSelectedReason] = useState('')
    const [comments, setComments] = useState('')
    const [submitted, setSubmitted] = useState(false)
    const [loading, setLoading] = useState(false)

    if (!order) {
        return (
            <div className="flex min-h-screen flex-col bg-background">
                <Header />
                <main className="flex-1">
                    <div className="mx-auto max-w-2xl px-4 py-8 sm:px-6 lg:px-8 text-center">
                        <h1 className="text-2xl font-bold text-foreground">Order not found</h1>
                        <Button asChild className="mt-6">
                            <Link to={"/orders"}>Back to Orders</Link>
                        </Button>
                    </div>
                </main>
                <Footer />
            </div>
        )
    }

    const itemToCancel = itemId
        ? order.items.find((item) => item.id === parseInt(itemId))
        : null
    const refundAmount = itemToCancel ? itemToCancel.price * itemToCancel.quantity : order.total

    const handleSubmit = async (e) => {
        e.preventDefault()
        if (!selectedReason) return

        setLoading(true)
        // Simulate API call
        await new Promise((resolve) => setTimeout(resolve, 1500))
        setLoading(false)
        setSubmitted(true)
    }

    if (submitted) {
        return (
            <div className="flex min-h-screen flex-col bg-background">
                {/* <Header /> */}

                <main className="flex-1">
                    <div className="mx-auto max-w-2xl px-4 py-12 sm:px-6 lg:px-8">
                        <div className="rounded-xl border border-border/60 bg-card p-8 text-center">
                            <div className="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-green-100">
                                <Check className="h-8 w-8 text-green-600" />
                            </div>

                            <h1 className="mt-6 text-2xl font-bold text-foreground" style={{ fontFamily: 'var(--font-heading)' }}>
                                Cancellation Request Submitted
                            </h1>

                            <p className="mt-4 text-muted-foreground">
                                Your {itemToCancel ? 'item' : 'order'} cancellation request has been received and is being processed.
                            </p>

                            <div className="mt-8 rounded-lg bg-blue-50 p-4 text-left">
                                <h3 className="font-semibold text-blue-900">What happens next?</h3>
                                <ul className="mt-3 space-y-2 text-sm text-blue-800">
                                    <li>• We will process your request within 24-48 hours</li>
                                    <li>• You will receive a confirmation email with cancellation details</li>
                                    <li>• Refunds are processed within 5-7 business days to your original payment method</li>
                                    <li>• If your item was already shipped, you will receive return instructions</li>
                                </ul>
                            </div>

                            <div className="mt-8 flex flex-col gap-3 sm:flex-row sm:justify-center">
                                <Button asChild variant="outline">
                                    <Link to={`/orders/${order.id}`}>View Order</Link>
                                </Button>
                                <Button asChild>
                                    <Link to={"/orders"}>Back to Orders</Link>
                                </Button>
                            </div>
                        </div>
                    </div>
                </main>

                <Footer />
            </div>
        )
    }

    return (
        <div className="flex min-h-screen flex-col bg-background">
            <Header />

            <main className="flex-1">
                <div className="mx-auto max-w-2xl px-4 py-8 sm:px-6 lg:px-8">
                    {/* Header */}
                    <div className="flex items-center gap-4 mb-8">
                        <Button variant="ghost" size="icon" asChild>
                            <Link to={`/orders/${order.id}`}>
                                <ArrowLeft className="h-5 w-5" />
                            </Link>
                        </Button>
                        <div>
                            <h1 className="text-3xl font-bold text-foreground" style={{ fontFamily: 'var(--font-heading)' }}>
                                {itemToCancel ? 'Cancel Item' : 'Cancel Order'}
                            </h1>
                            <p className="mt-1 text-muted-foreground">Order {order.id}</p>
                        </div>
                    </div>

                    {/* Warning */}
                    <div className="mb-8 rounded-xl bg-amber-50 border border-amber-200 p-4 flex gap-3">
                        <AlertCircle className="h-5 w-5 text-amber-600 flex-shrink-0 mt-0.5" />
                        <div>
                            <h3 className="font-semibold text-amber-900">Before you cancel</h3>
                            <p className="mt-1 text-sm text-amber-800">
                                Once you submit a cancellation request, it will be reviewed by our team. If your order has already been
                                shipped, you may still need to return the item for a refund.
                            </p>
                        </div>
                    </div>

                    {/* Cancellation Form */}
                    <form onSubmit={handleSubmit} className="space-y-6">
                        {/* Item Details */}
                        <div className="rounded-xl border border-border/60 bg-card p-6">
                            <h2 className="mb-4 font-semibold text-foreground" style={{ fontFamily: 'var(--font-heading)' }}>
                                {itemToCancel ? 'Item to Cancel' : 'Order Items'}
                            </h2>

                            {itemToCancel ? (
                                <div className="space-y-2">
                                    <p className="font-medium text-foreground">{itemToCancel.name}</p>
                                    <p className="text-sm text-muted-foreground">Qty: {itemToCancel.quantity}</p>
                                    <div className="mt-3 pt-3 border-t border-border/40">
                                        <p className="text-sm text-muted-foreground">Estimated Refund Amount</p>
                                        <p className="mt-1 text-2xl font-bold text-foreground">${refundAmount}</p>
                                    </div>
                                </div>
                            ) : (
                                <div className="space-y-3">
                                    {order.items.map((item) => (
                                        <div key={item.id} className="flex justify-between items-start py-2 border-b border-border/40 last:border-0">
                                            <div>
                                                <p className="font-medium text-foreground">{item.name}</p>
                                                <p className="text-sm text-muted-foreground">Qty: {item.quantity}</p>
                                            </div>
                                            <p className="font-medium text-foreground">${item.price * item.quantity}</p>
                                        </div>
                                    ))}
                                    <div className="mt-3 pt-3 border-t-2 border-border/60">
                                        <p className="text-sm text-muted-foreground">Estimated Refund Amount</p>
                                        <p className="mt-1 text-2xl font-bold text-foreground">${refundAmount}</p>
                                    </div>
                                </div>
                            )}
                        </div>

                        {/* Cancellation Reason */}
                        <div className="rounded-xl border border-border/60 bg-card p-6">
                            <h2 className="mb-4 font-semibold text-foreground" style={{ fontFamily: 'var(--font-heading)' }}>
                                Reason for Cancellation
                            </h2>

                            <div className="space-y-3">
                                {cancellationReasons.map((reason) => (
                                    <label key={reason.value} className="flex items-center gap-3 cursor-pointer p-3 rounded-lg border border-border/60 hover:bg-muted/50 transition-colors">
                                        <input
                                            type="radio"
                                            name="reason"
                                            value={reason.value}
                                            checked={selectedReason === reason.value}
                                            onChange={(e) => setSelectedReason(e.target.value)}
                                            className="h-4 w-4 cursor-pointer"
                                        />
                                        <span className="text-foreground">{reason.label}</span>
                                    </label>
                                ))}
                            </div>
                        </div>

                        {/* Additional Comments */}
                        <div className="rounded-xl border border-border/60 bg-card p-6">
                            <h2 className="mb-4 font-semibold text-foreground" style={{ fontFamily: 'var(--font-heading)' }}>
                                Additional Comments (Optional)
                            </h2>

                            <textarea
                                value={comments}
                                onChange={(e) => setComments(e.target.value)}
                                placeholder="Tell us more about your reason for cancellation..."
                                className="w-full px-4 py-3 rounded-lg border border-border/60 bg-background text-foreground placeholder-muted-foreground focus:outline-none focus:ring-2 focus:ring-primary/50"
                                rows={4}
                            />
                            <p className="mt-2 text-xs text-muted-foreground">{comments.length}/500 characters</p>
                        </div>

                        {/* Action Buttons */}
                        <div className="flex gap-3 border-t border-border/40 pt-6">
                            <Button type="button" variant="outline" asChild>
                                <Link to={`/orders/${order.id}`}>
                                    Keep Order
                                </Link>
                            </Button>
                            <Button
                                type="submit"
                                disabled={!selectedReason || loading}
                                className="flex-1"
                            >
                                {loading ? 'Processing...' : 'Submit Cancellation'}
                            </Button>
                        </div>
                    </form>

                    {/* Help Section */}
                    <div className="mt-12 rounded-xl bg-blue-50 border border-blue-200 p-6">
                        <h3 className="font-semibold text-blue-900">Need Help?</h3>
                        <p className="mt-2 text-sm text-blue-800">
                            If you have any questions about the cancellation process, please{' '}
                            <Link to={"/contact"} className="font-medium underline hover:no-underline">
                                contact our support team
                            </Link>
                            . We're here to help!
                        </p>
                    </div>
                </div>
            </main>

            {/* <Footer /> */}
        </div>
    )
}
