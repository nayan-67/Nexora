import { useState } from "react"
import { Link, useNavigate } from "react-router-dom"
import { ChevronLeft, CreditCard, Lock, Check, Truck } from "lucide-react"
import { Button } from "@/components/ui/button"
import { cn } from "@/lib/utils"

const orderItems = [
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
]

const steps = [
  { id: 1, name: "Shipping" },
  { id: 2, name: "Payment" },
  { id: 3, name: "Review" },
]

function FormField({ label, children, className }) {
  return (
    <div className={cn("space-y-2", className)}>
      <label className="text-sm font-medium text-foreground">{label}</label>
      {children}
    </div>
  )
}

export default function CheckoutPage() {
  const navigate = useNavigate()
  const [currentStep, setCurrentStep] = useState(1)
  const [isProcessing, setIsProcessing] = useState(false)
  const [formData, setFormData] = useState({
    email: "",
    firstName: "",
    lastName: "",
    address: "",
    city: "",
    state: "",
    zipCode: "",
    country: "United States",
    phone: "",
    cardNumber: "",
    cardName: "",
    expiry: "",
    cvv: "",
    saveInfo: true,
  })

  const subtotal = orderItems.reduce((sum, item) => sum + item.price * item.quantity, 0)
  const shipping = 0
  const tax = subtotal * 0.08
  const total = subtotal + shipping + tax

  const handleInputChange = (e) => {
    const { name, value, type, checked } = e.target
    setFormData(prev => ({
      ...prev,
      [name]: type === "checkbox" ? checked : value
    }))
  }

  const handleSubmit = async () => {
    if (currentStep < 3) {
      setCurrentStep(currentStep + 1)
    } else {
      setIsProcessing(true)
      await new Promise(resolve => setTimeout(resolve, 2000))
      navigate("/checkout/success")
    }
  }

  const inputClasses = "h-11 w-full rounded-lg border border-input bg-background px-4 text-sm outline-none transition-colors focus:border-primary focus:ring-2 focus:ring-ring"

  return (
    <div className="flex min-h-screen flex-col bg-background pt-18.75">
      {/* <Header /> */}

      <main className="flex-1">
        <div className="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
          {/* Back Link */}
          <Link
            to="/cart"
            className="inline-flex items-center gap-2 text-sm text-muted-foreground transition-colors hover:text-foreground"
          >
            <ChevronLeft className="h-4 w-4" />
            Back to Cart
          </Link>

          <h1 className="mt-6 text-3xl font-bold tracking-tight text-foreground sm:text-4xl" style={{ fontFamily: 'var(--font-heading)' }}>
            Checkout
          </h1>

          {/* Progress Steps */}
          <div className="mt-8">
            <div className="flex items-center justify-center">
              {steps.map((step, index) => (
                <div key={step.id} className="flex items-center">
                  <div className="flex items-center">
                    <div
                      className={cn(
                        "flex h-10 w-10 items-center justify-center rounded-full border-2 text-sm font-medium transition-colors",
                        currentStep > step.id
                          ? "border-primary bg-primary text-primary-foreground"
                          : currentStep === step.id
                            ? "border-primary text-primary"
                            : "border-muted text-muted-foreground"
                      )}
                    >
                      {currentStep > step.id ? (
                        <Check className="h-5 w-5" />
                      ) : (
                        step.id
                      )}
                    </div>
                    <span
                      className={cn(
                        "ml-3 text-sm font-medium",
                        currentStep >= step.id ? "text-foreground" : "text-muted-foreground"
                      )}
                    >
                      {step.name}
                    </span>
                  </div>
                  {index < steps.length - 1 && (
                    <div
                      className={cn(
                        "mx-4 h-0.5 w-16 sm:w-24",
                        currentStep > step.id ? "bg-primary" : "bg-muted"
                      )}
                    />
                  )}
                </div>
              ))}
            </div>
          </div>

          <div className="mt-8 grid gap-8 lg:grid-cols-3">
            {/* Form */}
            <div className="lg:col-span-2">
              <div className="rounded-2xl border border-border/60 bg-card p-6">
                {/* Step 1: Shipping */}
                {currentStep === 1 && (
                  <div>
                    <h2 className="text-xl font-semibold text-foreground" style={{ fontFamily: 'var(--font-heading)' }}>
                      Shipping Information
                    </h2>
                    <div className="mt-6 grid gap-4 sm:grid-cols-2">
                      <FormField label="Email" className="sm:col-span-2">
                        <input
                          type="email"
                          name="email"
                          value={formData.email}
                          onChange={handleInputChange}
                          placeholder="you@example.com"
                          className={inputClasses}
                        />
                      </FormField>
                      <FormField label="First Name">
                        <input
                          type="text"
                          name="firstName"
                          value={formData.firstName}
                          onChange={handleInputChange}
                          placeholder="John"
                          className={inputClasses}
                        />
                      </FormField>
                      <FormField label="Last Name">
                        <input
                          type="text"
                          name="lastName"
                          value={formData.lastName}
                          onChange={handleInputChange}
                          placeholder="Doe"
                          className={inputClasses}
                        />
                      </FormField>
                      <FormField label="Address" className="sm:col-span-2">
                        <input
                          type="text"
                          name="address"
                          value={formData.address}
                          onChange={handleInputChange}
                          placeholder="123 Main Street, Apt 4"
                          className={inputClasses}
                        />
                      </FormField>
                      <FormField label="City">
                        <input
                          type="text"
                          name="city"
                          value={formData.city}
                          onChange={handleInputChange}
                          placeholder="New York"
                          className={inputClasses}
                        />
                      </FormField>
                      <div className="grid grid-cols-2 gap-4">
                        <FormField label="State">
                          <input
                            type="text"
                            name="state"
                            value={formData.state}
                            onChange={handleInputChange}
                            placeholder="NY"
                            className={inputClasses}
                          />
                        </FormField>
                        <FormField label="ZIP Code">
                          <input
                            type="text"
                            name="zipCode"
                            value={formData.zipCode}
                            onChange={handleInputChange}
                            placeholder="10001"
                            className={inputClasses}
                          />
                        </FormField>
                      </div>
                      <FormField label="Phone">
                        <input
                          type="tel"
                          name="phone"
                          value={formData.phone}
                          onChange={handleInputChange}
                          placeholder="+1 (555) 000-0000"
                          className={inputClasses}
                        />
                      </FormField>
                      <FormField label="Country">
                        <select
                          name="country"
                          value={formData.country}
                          onChange={handleInputChange}
                          className={inputClasses}
                        >
                          <option>United States</option>
                          <option>Canada</option>
                          <option>United Kingdom</option>
                        </select>
                      </FormField>
                    </div>
                  </div>
                )}

                {/* Step 2: Payment */}
                {currentStep === 2 && (
                  <div>
                    <h2 className="text-xl font-semibold text-foreground" style={{ fontFamily: 'var(--font-heading)' }}>
                      Payment Method
                    </h2>
                    <div className="mt-6 rounded-xl border border-primary/20 bg-primary/5 p-4">
                      <div className="flex items-center gap-3">
                        <div className="flex h-10 w-10 items-center justify-center rounded-lg bg-primary/10">
                          <CreditCard className="h-5 w-5 text-primary" />
                        </div>
                        <div>
                          <p className="font-medium text-foreground">Credit / Debit Card</p>
                          <p className="text-sm text-muted-foreground">Visa, Mastercard, Amex</p>
                        </div>
                      </div>
                    </div>
                    <div className="mt-6 grid gap-4">
                      <FormField label="Card Number">
                        <input
                          type="text"
                          name="cardNumber"
                          value={formData.cardNumber}
                          onChange={handleInputChange}
                          placeholder="1234 5678 9012 3456"
                          className={inputClasses}
                        />
                      </FormField>
                      <FormField label="Name on Card">
                        <input
                          type="text"
                          name="cardName"
                          value={formData.cardName}
                          onChange={handleInputChange}
                          placeholder="John Doe"
                          className={inputClasses}
                        />
                      </FormField>
                      <div className="grid grid-cols-2 gap-4">
                        <FormField label="Expiry Date">
                          <input
                            type="text"
                            name="expiry"
                            value={formData.expiry}
                            onChange={handleInputChange}
                            placeholder="MM/YY"
                            className={inputClasses}
                          />
                        </FormField>
                        <FormField label="CVV">
                          <input
                            type="text"
                            name="cvv"
                            value={formData.cvv}
                            onChange={handleInputChange}
                            placeholder="123"
                            className={inputClasses}
                          />
                        </FormField>
                      </div>
                    </div>
                    <div className="mt-4 flex items-center gap-2 text-sm text-muted-foreground">
                      <Lock className="h-4 w-4" />
                      Your payment information is encrypted and secure
                    </div>
                  </div>
                )}

                {/* Step 3: Review */}
                {currentStep === 3 && (
                  <div>
                    <h2 className="text-xl font-semibold text-foreground" style={{ fontFamily: 'var(--font-heading)' }}>
                      Review Your Order
                    </h2>

                    {/* Shipping Summary */}
                    <div className="mt-6 rounded-xl border border-border/60 p-4">
                      <div className="flex items-center justify-between">
                        <h3 className="font-medium text-foreground">Shipping Address</h3>
                        <button
                          onClick={() => setCurrentStep(1)}
                          className="text-sm text-primary hover:underline"
                        >
                          Edit
                        </button>
                      </div>
                      <p className="mt-2 text-sm text-muted-foreground">
                        {formData.firstName} {formData.lastName}<br />
                        {formData.address}<br />
                        {formData.city}, {formData.state} {formData.zipCode}<br />
                        {formData.country}
                      </p>
                    </div>

                    {/* Payment Summary */}
                    <div className="mt-4 rounded-xl border border-border/60 p-4">
                      <div className="flex items-center justify-between">
                        <h3 className="font-medium text-foreground">Payment Method</h3>
                        <button
                          onClick={() => setCurrentStep(2)}
                          className="text-sm text-primary hover:underline"
                        >
                          Edit
                        </button>
                      </div>
                      <div className="mt-2 flex items-center gap-2">
                        <CreditCard className="h-4 w-4 text-muted-foreground" />
                        <span className="text-sm text-muted-foreground">
                          Card ending in {formData.cardNumber.slice(-4) || "****"}
                        </span>
                      </div>
                    </div>

                    {/* Order Items */}
                    <div className="mt-4 rounded-xl border border-border/60 p-4">
                      <h3 className="font-medium text-foreground">Order Items</h3>
                      <div className="mt-4 space-y-3">
                        {orderItems.map((item) => (
                          <div key={item.id} className="flex items-center gap-3">
                            <div className="h-12 w-12 overflow-hidden rounded-lg bg-muted">
                              <img src={item.image} alt={item.name} className="h-full w-full object-cover" />
                            </div>
                            <div className="flex-1">
                              <p className="text-sm font-medium text-foreground">{item.name}</p>
                              <p className="text-xs text-muted-foreground">Qty: {item.quantity}</p>
                            </div>
                            <p className="text-sm font-medium text-foreground">
                              ${(item.price * item.quantity).toFixed(2)}
                            </p>
                          </div>
                        ))}
                      </div>
                    </div>
                  </div>
                )}

                {/* Navigation Buttons */}
                <div className="mt-8 flex items-center justify-between">
                  {currentStep > 1 ? (
                    <Button
                      variant="outline"
                      onClick={() => setCurrentStep(currentStep - 1)}
                    >
                      Back
                    </Button>
                  ) : (
                    <div />
                  )}
                  <Button onClick={handleSubmit} disabled={isProcessing}>
                    {isProcessing ? (
                      "Processing..."
                    ) : currentStep === 3 ? (
                      `Pay $${total.toFixed(2)}`
                    ) : (
                      "Continue"
                    )}
                  </Button>
                </div>
              </div>
            </div>

            {/* Order Summary */}
            <div className="lg:col-span-1">
              <div className="sticky top-24 rounded-2xl border border-border/60 bg-card p-6">
                <h2 className="text-lg font-semibold text-foreground" style={{ fontFamily: 'var(--font-heading)' }}>
                  Order Summary
                </h2>

                <div className="mt-4 space-y-3">
                  {orderItems.map((item) => (
                    <div key={item.id} className="flex items-center gap-3">
                      <div className="relative h-14 w-14 overflow-hidden rounded-lg bg-muted">
                        <img src={item.image} alt={item.name} className="h-full w-full object-cover" />
                        <span className="absolute -right-1 -top-1 flex h-5 w-5 items-center justify-center rounded-full bg-primary text-xs font-medium text-primary-foreground">
                          {item.quantity}
                        </span>
                      </div>
                      <div className="flex-1">
                        <p className="text-sm font-medium text-foreground line-clamp-1">{item.name}</p>
                        <p className="text-sm text-muted-foreground">${item.price}</p>
                      </div>
                    </div>
                  ))}
                </div>

                <div className="mt-6 space-y-3 border-t border-border/40 pt-6">
                  <div className="flex justify-between text-sm">
                    <span className="text-muted-foreground">Subtotal</span>
                    <span className="text-foreground">${subtotal.toFixed(2)}</span>
                  </div>
                  <div className="flex justify-between text-sm">
                    <span className="text-muted-foreground">Shipping</span>
                    <span className="text-green-600">Free</span>
                  </div>
                  <div className="flex justify-between text-sm">
                    <span className="text-muted-foreground">Tax</span>
                    <span className="text-foreground">${tax.toFixed(2)}</span>
                  </div>
                  <div className="flex justify-between border-t border-border/40 pt-3 text-lg font-semibold">
                    <span className="text-foreground">Total</span>
                    <span className="text-foreground">${total.toFixed(2)}</span>
                  </div>
                </div>

                <div className="mt-6 flex items-center gap-2 rounded-lg bg-muted/50 p-3 text-sm text-muted-foreground">
                  <Truck className="h-4 w-4 shrink-0" />
                  <span>Estimated delivery: 3-5 business days</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>

      {/* <Footer /> */}
    </div>
  )
}
