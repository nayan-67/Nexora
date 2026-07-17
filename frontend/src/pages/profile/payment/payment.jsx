import { useState } from "react"
import { ChevronLeft, Plus, Edit2, Trash2, CreditCard, Check } from "lucide-react"
import { Button } from "@/components/ui/button"
import { cn } from "@/lib/utils"
import { Header } from "@/components/header"
import { Footer } from "@/components/footer"
import { Link } from "react-router-dom"

const initialPaymentMethods = [
  {
    id: 1,
    type: "credit",
    cardBrand: "Visa",
    lastFourDigits: "4242",
    holderName: "Sarah Anderson",
    expiryMonth: "12",
    expiryYear: "2025",
    isDefault: true,
  },
  {
    id: 2,
    type: "credit",
    cardBrand: "Mastercard",
    lastFourDigits: "5555",
    holderName: "Sarah Anderson",
    expiryMonth: "08",
    expiryYear: "2026",
    isDefault: false,
  },
  {
    id: 3,
    type: "credit",
    cardBrand: "American Express",
    lastFourDigits: "3782",
    holderName: "Sarah Anderson",
    expiryMonth: "06",
    expiryYear: "2024",
    isDefault: false,
  },
]

function FormField({ label, children, className, required }) {
  return (
    <div className={cn("space-y-2", className)}>
      <label className="text-sm font-medium text-foreground">
        {label}
        {required && <span className="ml-1 text-destructive">*</span>}
      </label>
      {children}
    </div>
  )
}

function CardBrandLogo({ brand }) {
  const logos = {
    Visa: "VI",
    Mastercard: "MC",
    "American Express": "AX",
    Discover: "DI",
  }
  return (
    <div className="flex h-8 w-12 items-center justify-center rounded bg-linear-to-br from-primary to-primary/70 text-[10px] font-bold text-primary-foreground">
      {logos[brand] || brand.substring(0, 2).toUpperCase()}
    </div>
  )
}

export default function PaymentMethodsPage() {
  const [paymentMethods, setPaymentMethods] = useState(initialPaymentMethods)
  const [showAddForm, setShowAddForm] = useState(false)
  const [editingId, setEditingId] = useState(null)
  const [formData, setFormData] = useState({
    cardBrand: "Visa",
    cardNumber: "",
    holderName: "",
    expiryMonth: "01",
    expiryYear: new Date().getFullYear().toString(),
    cvv: "",
  })

  const handleInputChange = (e) => {
    const { name, value } = e.target
    setFormData(prev => ({ ...prev, [name]: value }))
  }

  const handleAddPaymentMethod = () => {
    if (!formData.cardNumber || !formData.holderName || !formData.cvv) return
    const lastFourDigits = formData.cardNumber.slice(-4)
    const newMethod = {
      id: Date.now(),
      type: "credit",
      cardBrand: formData.cardBrand,
      lastFourDigits,
      holderName: formData.holderName,
      expiryMonth: formData.expiryMonth,
      expiryYear: formData.expiryYear,
      isDefault: paymentMethods.length === 0,
    }
    setPaymentMethods([...paymentMethods, newMethod])
    resetForm()
  }

  const handleUpdatePaymentMethod = () => {
    if (!formData.holderName || !formData.expiryMonth || !formData.expiryYear) return
    const lastFourDigits = formData.cardNumber.slice(-4)
    setPaymentMethods(paymentMethods.map(method =>
      method.id === editingId 
        ? { 
            ...method, 
            holderName: formData.holderName,
            expiryMonth: formData.expiryMonth,
            expiryYear: formData.expiryYear,
            lastFourDigits: formData.cardNumber ? lastFourDigits : method.lastFourDigits,
          }
        : method
    ))
    resetForm()
  }

  const handleDeletePaymentMethod = (id) => {
    const newMethods = paymentMethods.filter(method => method.id !== id)
    if (newMethods.length > 0 && paymentMethods.find(m => m.id === id)?.isDefault) {
      newMethods[0].isDefault = true
    }
    setPaymentMethods(newMethods)
  }

  const handleSetDefault = (id) => {
    setPaymentMethods(paymentMethods.map(method => ({
      ...method,
      isDefault: method.id === id,
    })))
  }

  const handleEditClick = (method) => {
    setFormData({
      cardBrand: method.cardBrand,
      cardNumber: "",
      holderName: method.holderName,
      expiryMonth: method.expiryMonth,
      expiryYear: method.expiryYear,
      cvv: "",
    })
    setEditingId(method.id)
    setShowAddForm(true)
  }

  const resetForm = () => {
    setFormData({
      cardBrand: "Visa",
      cardNumber: "",
      holderName: "",
      expiryMonth: "01",
      expiryYear: new Date().getFullYear().toString(),
      cvv: "",
    })
    setEditingId(null)
    setShowAddForm(false)
  }

  const inputClasses = "h-11 w-full rounded-lg border border-input bg-background px-4 text-sm outline-none transition-colors focus:border-primary focus:ring-2 focus:ring-ring"

  return (
    <div className="flex min-h-screen flex-col bg-background">
      <Header />

      <main className="flex-1">
        <div className="mx-auto max-w-4xl px-4 py-8 sm:px-6 lg:px-8">
          {/* Back Link */}
          <Link
            to="/profile"
            className="inline-flex items-center gap-2 text-sm text-muted-foreground transition-colors hover:text-foreground"
          >
            <ChevronLeft className="h-4 w-4" />
            Back to Profile
          </Link>

          <div className="mt-6 flex items-center justify-between">
            <div>
              <h1 className="text-3xl font-bold tracking-tight text-foreground" style={{ fontFamily: 'var(--font-heading)' }}>
                Payment Methods
              </h1>
              <p className="mt-2 text-muted-foreground">
                Add and manage your payment methods for faster checkout
              </p>
            </div>
            {!showAddForm && (
              <Button onClick={() => setShowAddForm(true)} className="gap-2">
                <Plus className="h-4 w-4" />
                Add Card
              </Button>
            )}
          </div>

          {/* Add/Edit Form */}
          {showAddForm && (
            <div className="mt-6 rounded-2xl border border-border/60 bg-card p-6">
              <h2 className="font-semibold text-foreground" style={{ fontFamily: 'var(--font-heading)' }}>
                {editingId ? "Edit Card" : "Add New Card"}
              </h2>
              <div className="mt-6 grid gap-4 sm:grid-cols-2">
                <FormField label="Card Brand" className="sm:col-span-2">
                  <select
                    name="cardBrand"
                    value={formData.cardBrand}
                    onChange={handleInputChange}
                    className={inputClasses}
                  >
                    <option>Visa</option>
                    <option>Mastercard</option>
                    <option>American Express</option>
                    <option>Discover</option>
                  </select>
                </FormField>
                <FormField label="Card Number" required className="sm:col-span-2">
                  <input
                    type="text"
                    name="cardNumber"
                    value={formData.cardNumber}
                    onChange={handleInputChange}
                    placeholder="4242 4242 4242 4242"
                    maxLength="19"
                    className={inputClasses}
                    required
                  />
                </FormField>
                <FormField label="Cardholder Name" required>
                  <input
                    type="text"
                    name="holderName"
                    value={formData.holderName}
                    onChange={handleInputChange}
                    placeholder="Sarah Anderson"
                    className={inputClasses}
                    required
                  />
                </FormField>
                <FormField label="CVV" required>
                  <input
                    type="password"
                    name="cvv"
                    value={formData.cvv}
                    onChange={handleInputChange}
                    placeholder="123"
                    maxLength="4"
                    className={inputClasses}
                    required
                  />
                </FormField>
                <div className="grid grid-cols-2 gap-4">
                  <FormField label="Expiry Month" required>
                    <select
                      name="expiryMonth"
                      value={formData.expiryMonth}
                      onChange={handleInputChange}
                      className={inputClasses}
                      required
                    >
                      {Array.from({ length: 12 }, (_, i) => {
                        const month = String(i + 1).padStart(2, "0")
                        return (
                          <option key={month} value={month}>
                            {month}
                          </option>
                        )
                      })}
                    </select>
                  </FormField>
                  <FormField label="Expiry Year" required>
                    <select
                      name="expiryYear"
                      value={formData.expiryYear}
                      onChange={handleInputChange}
                      className={inputClasses}
                      required
                    >
                      {Array.from({ length: 10 }, (_, i) => {
                        const year = (new Date().getFullYear() + i).toString()
                        return (
                          <option key={year} value={year}>
                            {year}
                          </option>
                        )
                      })}
                    </select>
                  </FormField>
                </div>
              </div>
              <div className="mt-6 flex items-center justify-end gap-3">
                <Button variant="outline" onClick={resetForm}>
                  Cancel
                </Button>
                <Button
                  onClick={editingId ? handleUpdatePaymentMethod : handleAddPaymentMethod}
                >
                  {editingId ? "Update Card" : "Add Card"}
                </Button>
              </div>
            </div>
          )}

          {/* Payment Methods List */}
          <div className="mt-6 space-y-3">
            {paymentMethods.length === 0 ? (
              <div className="rounded-2xl border-2 border-dashed border-border/60 bg-card/40 py-12 text-center">
                <CreditCard className="mx-auto h-12 w-12 text-muted-foreground/30" />
                <h3 className="mt-4 text-lg font-semibold text-foreground" style={{ fontFamily: 'var(--font-heading)' }}>
                  No payment methods added
                </h3>
                <p className="mt-2 text-muted-foreground">
                  Add a card to get started with faster checkout
                </p>
                <Button onClick={() => setShowAddForm(true)} className="mt-6">
                  Add Your First Card
                </Button>
              </div>
            ) : (
              paymentMethods.map((method) => (
                <div
                  key={method.id}
                  className={cn(
                    "relative overflow-hidden rounded-xl border bg-card p-6 transition-all hover:border-primary/30 hover:shadow-sm",
                    method.isDefault ? "border-primary/50" : "border-border/60"
                  )}
                >
                  {/* Background gradient based on card brand */}
                  <div className="absolute inset-0 opacity-5">
                    <div className="absolute top-0 right-0 h-40 w-40 rounded-full bg-primary blur-3xl" />
                  </div>

                  <div className="relative flex items-center justify-between">
                    <div className="flex items-start gap-4">
                      <CardBrandLogo brand={method.cardBrand} />
                      <div>
                        <h3 className="font-semibold text-foreground">{method.cardBrand}</h3>
                        <p className="mt-1 text-lg font-mono tracking-wide text-muted-foreground">
                          •••• •••• •••• {method.lastFourDigits}
                        </p>
                        <p className="mt-2 text-sm text-muted-foreground">
                          {method.holderName}
                        </p>
                        <p className="text-xs text-muted-foreground">
                          Expires {method.expiryMonth}/{method.expiryYear}
                        </p>
                      </div>
                    </div>

                    {method.isDefault && (
                      <span className="inline-flex items-center gap-1 rounded-full bg-primary/10 px-3 py-1 text-xs font-medium text-primary">
                        <Check className="h-3 w-3" />
                        Default
                      </span>
                    )}
                  </div>

                  {/* Actions */}
                  <div className="absolute right-6 top-20 flex items-center gap-2">
                    {!method.isDefault && (
                      <Button
                        size="sm"
                        variant="outline"
                        onClick={() => handleSetDefault(method.id)}
                        className="text-xs"
                      >
                        Set Default
                      </Button>
                    )}
                    <Button
                      size="sm"
                      variant="outline"
                      onClick={() => handleEditClick(method)}
                      className="gap-2"
                    >
                      <Edit2 className="h-4 w-4" />
                    </Button>
                    <Button
                      size="sm"
                      variant="outline"
                      onClick={() => handleDeletePaymentMethod(method.id)}
                      className="text-destructive hover:bg-destructive/10"
                    >
                      <Trash2 className="h-4 w-4" />
                    </Button>
                  </div>
                </div>
              ))
            )}
          </div>

          {/* Security Note */}
          <div className="mt-8 rounded-xl border border-border/40 bg-card/50 p-4">
            <p className="text-xs text-muted-foreground">
              <strong>Security Note:</strong> Your payment information is encrypted and secured. We never store full card details on our servers. For online transactions, we use PCI DSS compliant payment processing.
            </p>
          </div>
        </div>
      </main>

      <Footer />
    </div>
  )
}
