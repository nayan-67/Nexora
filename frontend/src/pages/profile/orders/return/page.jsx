import { useState } from 'react'
import { ArrowLeft, AlertCircle, Check, Package, Truck, RefreshCw } from 'lucide-react'
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

const returnReasons = [
    { value: 'defective', label: 'Product is defective/damaged' },
    { value: 'not-as-described', label: 'Not as described or different from listing' },
    { value: 'wrong-size', label: 'Wrong size or fit' },
    { value: 'wrong-color', label: 'Wrong color or model' },
    { value: 'changed-mind', label: 'Changed my mind' },
    { value: 'unwanted-gift', label: 'Unwanted gift' },
    { value: 'other', label: 'Other reason' },
]

const returnWindow = {
    days: 30,
    startDate: 'March 30, 2026',
    endDate: 'April 29, 2026',
}

export default function ReturnPage() {
    const params = useParams()
    const [searchParams] = useSearchParams()
    const order = orders.find((o) => o.id === params.id)
    const itemId = searchParams.get('item')

    const [step, setStep] = useState('select')
    const [returnChoice, setReturnChoice] = useState('refund')
    const [selectedItems, setSelectedItems] = useState(itemId ? [parseInt(itemId)] : [])
    const [selectedReasons, setSelectedReasons] = useState({})
    const [comments, setComments] = useState('')
    const [returnMethod, setReturnMethod] = useState('prepaid-label')
    const [submitted, setSubmitted] = useState(false)

    if (!order) {
        return (
            <div className="flex min-h-screen flex-col bg-background">
                {/* <Header /> */}
                <main className="flex-1">
                    <div className="mx-auto max-w-4xl px-4 py-8 sm:px-6 lg:px-8 text-center">
                        <h1 className="text-2xl font-bold text-foreground">Order not found</h1>
                        <Button asChild className="mt-6">
                            <Link to={"/orders"}>Back to Orders</Link>
                        </Button>
                    </div>
                </main>
                {/* <Footer /> */}
            </div>
        )
    }

    const handleItemToggle = (itemId) => {
        setSelectedItems((prev) =>
            prev.includes(itemId) ? prev.filter((id) => id !== itemId) : [...prev, itemId]
        )
    }

    const handleReasonChange = (itemId, reason) => {
        setSelectedReasons((prev) => ({
            ...prev,
            [itemId]: reason,
        }))
    }

    const handleSubmit = () => {
        setSubmitted(true)
        setTimeout(() => {
            setStep('confirmation')
        }, 500)
    }

    const calculateRefund = () => {
        return selectedItems.reduce((total, itemId) => {
            const item = order.items.find((i) => i.id === itemId)
            return total + item.price * item.quantity
        }, 0)
    }

    if (submitted && step === 'confirmation') {
        return (
            <div className="flex min-h-screen flex-col bg-background">
                {/* <Header /> */}
                <main className="flex-1">
                    <div className="mx-auto max-w-2xl px-4 py-16 sm:px-6 lg:px-8">
                        <div className="rounded-2xl border-2 border-green-200 bg-green-50 p-8 text-center">
                            <div className="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-green-100">
                                <Check className="h-8 w-8 text-green-600" />
                            </div>
                            <h1 className="mt-4 text-3xl font-bold text-green-900" style={{ fontFamily: 'var(--font-heading)' }}>
                                Return Request Submitted
                            </h1>
                            <p className="mt-2 text-green-800">Your return request has been received and is being processed.</p>

                            <div className="mt-8 space-y-4 rounded-xl bg-white p-6 text-left">
                                <div>
                                    <p className="text-sm font-medium text-muted-foreground">Return Reference Number</p>
                                    <p className="mt-1 text-lg font-semibold text-foreground">RET-{Math.random().toString(36).substr(2, 9).toUpperCase()}</p>
                                </div>
                                <div>
                                    <p className="text-sm font-medium text-muted-foreground">Refund Amount</p>
                                    <p className="mt-1 text-lg font-semibold text-foreground">${calculateRefund().toFixed(2)}</p>
                                </div>
                                <div>
                                    <p className="text-sm font-medium text-muted-foreground">Items Being Returned</p>
                                    <div className="mt-2 space-y-1">
                                        {selectedItems.map((itemId) => {
                                            const item = order.items.find((i) => i.id === itemId)
                                            return (
                                                <p key={itemId} className="text-sm text-foreground">
                                                    • {item.name} (Qty: {item.quantity})
                                                </p>
                                            )
                                        })}
                                    </div>
                                </div>
                            </div>

                            <div className="mt-8 space-y-3 rounded-xl bg-blue-50 p-6 text-left border border-blue-200">
                                <div className="flex gap-3">
                                    <Truck className="h-5 w-5 flex-shrink-0 text-blue-600 mt-0.5" />
                                    <div>
                                        <h3 className="font-semibold text-blue-900">Next Steps</h3>
                                        <ul className="mt-2 space-y-1 text-sm text-blue-800">
                                            <li>• You&apos;ll receive a prepaid return label via email within 24 hours</li>
                                            <li>• Pack the items securely in their original packaging if possible</li>
                                            <li>• Drop off at any carrier location using the prepaid label</li>
                                            {returnChoice === 'refund' ? (
                                                <li>• Refund will be processed within 7 business days of receipt</li>
                                            ) : (
                                                <li>• Your replacement will ship as soon as we receive your return</li>
                                            )}
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div className="mt-4 rounded-xl bg-amber-50 p-4 border border-amber-200">
                                <p className="text-sm text-amber-900">
                                    <strong>Resolution Type:</strong> {returnChoice === 'refund' ? 'Refund' : 'Replacement'}
                                </p>
                            </div>

                            <div className="mt-8 flex items-center justify-center gap-3">
                                <Button asChild variant="outline">
                                    <Link to={"/orders"}>Back to Orders</Link>
                                </Button>
                                <Button asChild>
                                    <Link to={`/orders/${order.id}`}>View Order</Link>
                                </Button>
                            </div>
                        </div>
                    </div>
                </main>
                {/* <Footer /> */}
            </div>
        )
    }

    if (step === 'confirmation') {
        return (
            <div className="flex min-h-screen flex-col bg-background">
                {/* <Header /> */}
                <main className="flex-1">
                    <div className="mx-auto max-w-2xl px-4 py-8 sm:px-6 lg:px-8">
                        <Link to={`/orders/${order.id}`} className="inline-flex items-center gap-2 text-primary hover:underline mb-6">
                            <ArrowLeft className="h-4 w-4" />
                            Back to Order
                        </Link>
                        <div className="rounded-2xl border border-border/60 bg-card p-8">
                            <h1 className="text-2xl font-bold text-foreground" style={{ fontFamily: 'var(--font-heading)' }}>
                                Confirm Return Request
                            </h1>
                            <p className="mt-2 text-muted-foreground">Please review your return request before submission</p>

                            <div className="mt-8 space-y-6">
                                <div className="rounded-xl bg-muted p-4">
                                    <h2 className="font-semibold text-foreground">Items to Return</h2>
                                    <div className="mt-4 space-y-2">
                                        {selectedItems.map((itemId) => {
                                            const item = order.items.find((i) => i.id === itemId)
                                            const reason = selectedReasons[itemId]
                                            return (
                                                <div key={itemId} className="flex items-start justify-between rounded-lg border border-border/40 bg-card p-3">
                                                    <div>
                                                        <p className="font-medium text-foreground">{item.name}</p>
                                                        <p className="mt-1 text-sm text-muted-foreground">Qty: {item.quantity}</p>
                                                        <p className="mt-1 text-sm text-primary">Reason: {returnReasons.find((r) => r.value === reason)?.label}</p>
                                                    </div>
                                                    <p className="text-sm font-semibold text-foreground">${(item.price * item.quantity).toFixed(2)}</p>
                                                </div>
                                            )
                                        })}
                                    </div>
                                </div>

                                <div className="space-y-3">
                                    <div className="rounded-xl bg-blue-50 border border-blue-200 p-4">
                                        <div className="flex gap-3">
                                            {returnChoice === 'refund' ? (
                                                <>
                                                    <RefreshCw className="h-5 w-5 flex-shrink-0 text-blue-600 mt-0.5" />
                                                    <div>
                                                        <p className="font-medium text-blue-900">Request Type: Refund</p>
                                                        <p className="mt-1 text-sm text-blue-800">You will receive your refund after we process your return</p>
                                                    </div>
                                                </>
                                            ) : (
                                                <>
                                                    <Package className="h-5 w-5 flex-shrink-0 text-green-600 mt-0.5" />
                                                    <div>
                                                        <p className="font-medium text-green-900">Request Type: Replacement</p>
                                                        <p className="mt-1 text-sm text-green-800">Your replacement will be shipped upon receipt of your return</p>
                                                    </div>
                                                </>
                                            )}
                                        </div>
                                    </div>
                                    <div className="rounded-xl bg-purple-50 border border-purple-200 p-4">
                                        <div className="flex gap-3">
                                            <Truck className="h-5 w-5 flex-shrink-0 text-purple-600 mt-0.5" />
                                            <div>
                                                <p className="font-medium text-purple-900">Return Method: Prepaid Label</p>
                                                <p className="mt-1 text-sm text-purple-800">A prepaid return shipping label will be emailed to you immediately</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {comments && (
                                    <div className="rounded-xl bg-muted p-4">
                                        <p className="text-sm font-medium text-foreground">Additional Comments</p>
                                        <p className="mt-2 text-sm text-muted-foreground">{comments}</p>
                                    </div>
                                )}

                                <div className="rounded-xl bg-amber-50 border border-amber-200 p-4">
                                    <div className="flex gap-3">
                                        <AlertCircle className="h-5 w-5 flex-shrink-0 text-amber-600 mt-0.5" />
                                        <div>
                                            <p className="font-medium text-amber-900">Important</p>
                                            <p className="mt-1 text-sm text-amber-800">Please ensure items are in original condition. Damaged or heavily used items may affect your refund.</p>
                                        </div>
                                    </div>
                                </div>

                                <div className="border-t border-border/40 pt-6">
                                    <div className="flex items-center justify-between">
                                        <div>
                                            <p className="text-sm text-muted-foreground">Total Refund Amount</p>
                                            <p className="text-2xl font-bold text-foreground">${calculateRefund().toFixed(2)}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div className="mt-8 flex items-center justify-between gap-3">
                                <Button variant="outline" onClick={() => setStep('select')}>
                                    Edit Selection
                                </Button>
                                <Button onClick={handleSubmit}>
                                    Submit {returnChoice === 'refund' ? 'Refund' : 'Replacement'} Request
                                </Button>
                            </div>
                        </div>
                    </div>
                </main>
                {/* <Footer /> */}
            </div>
        )
    }

    return (
        <div className="flex min-h-screen flex-col bg-background">
            {/* <Header /> */}
            <main className="flex-1">
                <div className="mx-auto max-w-2xl px-4 py-8 sm:px-6 lg:px-8">
                    <Link to={`/orders/${order.id}`} className="inline-flex items-center gap-2 text-primary hover:underline mb-6">
                        <ArrowLeft className="h-4 w-4" />
                        Back to Order
                    </Link>

                    <div className="rounded-2xl border border-border/60 bg-card p-6 sm:p-8">
                        <h1 className="text-2xl font-bold text-foreground" style={{ fontFamily: 'var(--font-heading)' }}>
                            Request Product Return
                        </h1>
                        <p className="mt-2 text-muted-foreground">Select items you want to return and provide a reason</p>

                        {/* Return Window Info */}
                        <div className="mt-6 rounded-xl bg-blue-50 border border-blue-200 p-4">
                            <div className="flex gap-3">
                                <Package className="h-5 w-5 flex-shrink-0 text-blue-600 mt-0.5" />
                                <div>
                                    <p className="font-medium text-blue-900">Return Window</p>
                                    <p className="text-sm text-blue-800">You have until <strong>{returnWindow.endDate}</strong> to initiate returns ({returnWindow.days} days from delivery)</p>
                                </div>
                            </div>
                        </div>

                        {/* Select Items */}
                        <div className="mt-8">
                            <h2 className="font-semibold text-foreground mb-4">Select Items to Return</h2>
                            <div className="space-y-3">
                                {order.items.map((item) => (
                                    <div
                                        key={item.id}
                                        className="rounded-xl border border-border/60 p-4 hover:border-primary/30 transition-colors"
                                    >
                                        <div className="flex items-start gap-4">
                                            <input
                                                type="checkbox"
                                                checked={selectedItems.includes(item.id)}
                                                onChange={() => handleItemToggle(item.id)}
                                                className="mt-1 h-5 w-5 rounded accent-primary cursor-pointer"
                                            />
                                            <div className="flex-1">
                                                <div className="flex items-start justify-between mb-3">
                                                    <div>
                                                        <h3 className="font-medium text-foreground">{item.name}</h3>
                                                        <p className="mt-1 text-sm text-muted-foreground">Qty: {item.quantity} × ${item.price.toFixed(2)}</p>
                                                    </div>
                                                    <p className="text-sm font-semibold text-foreground">${(item.price * item.quantity).toFixed(2)}</p>
                                                </div>

                                                {selectedItems.includes(item.id) && (
                                                    <div className="mt-4 pt-4 border-t border-border/40">
                                                        <label className="block text-sm font-medium text-foreground mb-2">Reason for Return</label>
                                                        <select
                                                            value={selectedReasons[item.id] || ''}
                                                            onChange={(e) => handleReasonChange(item.id, e.target.value)}
                                                            className="w-full rounded-lg border border-border/60 bg-background px-3 py-2 text-sm text-foreground placeholder-muted-foreground focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
                                                            required
                                                        >
                                                            <option value="">Select a reason...</option>
                                                            {returnReasons.map((reason) => (
                                                                <option key={reason.value} value={reason.value}>
                                                                    {reason.label}
                                                                </option>
                                                            ))}
                                                        </select>
                                                    </div>
                                                )}
                                            </div>
                                        </div>
                                    </div>
                                ))}
                            </div>
                        </div>

                        {/* Additional Comments */}
                        <div className="mt-8">
                            <label className="block text-sm font-medium text-foreground mb-2">Additional Comments (Optional)</label>
                            <textarea
                                value={comments}
                                onChange={(e) => setComments(e.target.value)}
                                placeholder="Tell us more about why you're returning this item..."
                                className="w-full rounded-lg border border-border/60 bg-background px-3 py-2 text-sm text-foreground placeholder-muted-foreground focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
                                rows={4}
                            />
                        </div>

                        {/* Resolution Type */}
                        <div className="mt-8">
                            <h2 className="font-semibold text-foreground mb-6" style={{ fontFamily: 'var(--font-heading)' }}>What would you like?</h2>
                            <div className="grid gap-4 sm:grid-cols-2">
                                {/* Refund Card */}
                                <button
                                    onClick={() => setReturnChoice('refund')}
                                    className={`group relative overflow-hidden rounded-2xl p-6 transition-all duration-300 text-left border-2 hover:shadow-lg hover:-translate-y-1 ${returnChoice === 'refund'
                                            ? 'border-blue-500 bg-gradient-to-br from-blue-50 to-blue-50/50 shadow-md'
                                            : 'border-border/40 bg-card hover:border-blue-300/50 hover:bg-blue-50/30'
                                        }`}
                                >
                                    <input
                                        type="radio"
                                        name="return-choice"
                                        value="refund"
                                        checked={returnChoice === 'refund'}
                                        onChange={(e) => setReturnChoice(e.target.value)}
                                        className="sr-only"
                                    />
                                    <div className="relative z-10">
                                        <div className="mb-4 inline-flex h-14 w-14 items-center justify-center rounded-full bg-gradient-to-br from-blue-100 to-blue-200 transition-transform group-hover:scale-110 group-hover:rotate-6">
                                            <RefreshCw className="h-7 w-7 text-blue-600" strokeWidth={2} />
                                        </div>
                                        <h3 className="text-lg font-bold text-foreground" style={{ fontFamily: 'var(--font-heading)' }}>
                                            Get a Refund
                                        </h3>
                                        <p className="mt-2 text-sm text-muted-foreground leading-relaxed">
                                            Return the item and get your money back to the original payment method.
                                        </p>
                                        <ul className="mt-4 space-y-2 text-xs text-muted-foreground">
                                            <li className="flex items-center gap-2">
                                                <span className="inline-flex h-4 w-4 items-center justify-center rounded-full bg-blue-200 text-blue-700 text-[10px] font-bold">✓</span>
                                                Free return shipping label
                                            </li>
                                            <li className="flex items-center gap-2">
                                                <span className="inline-flex h-4 w-4 items-center justify-center rounded-full bg-blue-200 text-blue-700 text-[10px] font-bold">✓</span>
                                                7-day processing time
                                            </li>
                                        </ul>
                                    </div>
                                    {returnChoice === 'refund' && (
                                        <div className="absolute right-0 top-0 h-1.5 w-full bg-gradient-to-r from-blue-400 to-blue-600"></div>
                                    )}
                                </button>

                                {/* Replacement Card */}
                                <button
                                    onClick={() => setReturnChoice('replace')}
                                    className={`group relative overflow-hidden rounded-2xl p-6 transition-all duration-300 text-left border-2 hover:shadow-lg hover:-translate-y-1 ${returnChoice === 'replace'
                                            ? 'border-green-500 bg-gradient-to-br from-green-50 to-green-50/50 shadow-md'
                                            : 'border-border/40 bg-card hover:border-green-300/50 hover:bg-green-50/30'
                                        }`}
                                >
                                    <input
                                        type="radio"
                                        name="return-choice"
                                        value="replace"
                                        checked={returnChoice === 'replace'}
                                        onChange={(e) => setReturnChoice(e.target.value)}
                                        className="sr-only"
                                    />
                                    <div className="relative z-10">
                                        <div className="mb-4 inline-flex h-14 w-14 items-center justify-center rounded-full bg-gradient-to-br from-green-100 to-green-200 transition-transform group-hover:scale-110 group-hover:rotate-6">
                                            <Package className="h-7 w-7 text-green-600" strokeWidth={2} />
                                        </div>
                                        <h3 className="text-lg font-bold text-foreground" style={{ fontFamily: 'var(--font-heading)' }}>
                                            Get a Replacement
                                        </h3>
                                        <p className="mt-2 text-sm text-muted-foreground leading-relaxed">
                                            Return the item and receive a replacement shipped to you right away.
                                        </p>
                                        <ul className="mt-4 space-y-2 text-xs text-muted-foreground">
                                            <li className="flex items-center gap-2">
                                                <span className="inline-flex h-4 w-4 items-center justify-center rounded-full bg-green-200 text-green-700 text-[10px] font-bold">✓</span>
                                                Free return shipping label
                                            </li>
                                            <li className="flex items-center gap-2">
                                                <span className="inline-flex h-4 w-4 items-center justify-center rounded-full bg-green-200 text-green-700 text-[10px] font-bold">✓</span>
                                                Expedited replacement
                                            </li>
                                        </ul>
                                    </div>
                                    {returnChoice === 'replace' && (
                                        <div className="absolute right-0 top-0 h-1.5 w-full bg-gradient-to-r from-green-400 to-green-600"></div>
                                    )}
                                </button>
                            </div>
                        </div>

                        {/* Return Method */}
                        <div className="mt-8">
                            <h2 className="font-semibold text-foreground mb-4">Return Shipping Method</h2>
                            <div className="space-y-3">
                                <label className="flex items-start gap-3 rounded-xl border border-primary/50 bg-primary/5 p-4 cursor-pointer">
                                    <input
                                        type="radio"
                                        name="return-method"
                                        value="prepaid-label"
                                        checked={returnMethod === 'prepaid-label'}
                                        onChange={(e) => setReturnMethod(e.target.value)}
                                        className="mt-1 accent-primary"
                                    />
                                    <div>
                                        <p className="font-medium text-foreground">Prepaid Return Label (Recommended)</p>
                                        <p className="text-sm text-muted-foreground">Free return shipping - label will be emailed to you</p>
                                    </div>
                                </label>
                            </div>
                        </div>

                        {/* Refund Info */}
                        {selectedItems.length > 0 && (
                            <div className="mt-8 rounded-xl bg-muted p-4">
                                <div className="flex items-center justify-between">
                                    <div>
                                        <p className="text-sm text-muted-foreground">Estimated Refund Amount</p>
                                        <p className="text-2xl font-bold text-foreground mt-1">${calculateRefund().toFixed(2)}</p>
                                        <p className="text-xs text-muted-foreground mt-2">Refund will be processed within 7 business days of receipt</p>
                                    </div>
                                </div>
                            </div>
                        )}

                        {/* Action Buttons */}
                        <div className="mt-8 flex items-center justify-between gap-3">
                            <Button asChild variant="outline">
                                <Link to={`/orders/${order.id}`}>Cancel</Link>
                            </Button>
                            <Button
                                onClick={() => setStep('confirmation')}
                                disabled={selectedItems.length === 0 || Object.keys(selectedReasons).length !== selectedItems.length}
                            >
                                Continue to Review
                            </Button>
                        </div>
                    </div>
                </div>
            </main>
            {/* <Footer /> */}
        </div>
    )
}
