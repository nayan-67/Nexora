import { useContext, useEffect, useState } from "react"
import { ChevronLeft, Plus, Edit2, Trash2, MapPin, Check } from "lucide-react"
import { Button } from "@/components/ui/button"
import { cn } from "@/lib/utils"
import { Header } from "@/components/header"
import { Footer } from "@/components/footer"
import { Link } from "react-router-dom"
import { states } from "@/lib/state"
import api from "@/lib/api"
import { toast } from "react-hot-toast"
import { AuthContext } from "@/context/AuthContext"


// const initialAddresses = [
//   {
//     id: 1,
//     name: "Home",
//     street: "123 Innovation Boulevard",
//     apartment: "Suite 400",
//     city: "San Francisco",
//     state: "CA",
//     zip: "94102",
//     country: "United States",
//     phone: "+1 (555) 123-4567",
//     isDefault: true,
//   },
//   {
//     id: 2,
//     name: "Work",
//     street: "456 Tech Plaza",
//     apartment: "Floor 10",
//     city: "San Francisco",
//     state: "CA",
//     zip: "94103",
//     country: "United States",
//     phone: "+1 (555) 987-6543",
//     isDefault: false,
//   },
//   {
//     id: 3,
//     name: "Parent's House",
//     street: "789 Oak Street",
//     apartment: "",
//     city: "Los Angeles",
//     state: "CA",
//     zip: "90001",
//     country: "United States",
//     phone: "+1 (555) 555-5555",
//     isDefault: false,
//   },
// ]

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

export default function ManageAddressesPage() {
  const [addresses, setAddresses] = useState({})
  const [showAddForm, setShowAddForm] = useState(false)
  const [editingId, setEditingId] = useState(null)
  const { userData, setUserData } = useContext(AuthContext)

  const [formData, setFormData] = useState({})

  useEffect(() => {
    let active = true

    api.get("/address")
      .then((res) => {
        if (active) {
          setAddresses(res.data)
        }
      })
      .catch((err) => {
        console.error(err)
      })
    return () => {
      active = false;
    };
  }, [])


  const handleInputChange = (e) => {
    const { name, value } = e.target
    setFormData(prev => ({ ...prev, [name]: value }))
  }

  const handleAddAddress = () => {
    if (!formData.name || !formData.street || !formData.city) return
    const newAddress = {
      id: Date.now(),
      ...formData,
      isDefault: addresses.length === 0,
    }
    setAddresses([...addresses, newAddress])
    resetForm()
  }

  const handleUpdateAddress = () => {
    api.post("/address/update", formData)
      .then((res) => {
        toast.success("Address Updated")
        setUserData(res.data)
        setAddresses(res.data.addresses)
        resetForm()
      })
      .catch((err) => {
        console.log(err)
      })
  }

  const handleDeleteAddress = (id) => {
    const newAddresses = addresses.filter(addr => addr.id !== id)
    if (newAddresses.length > 0 && addresses.find(a => a.id === id)?.isDefault) {
      newAddresses[0].isDefault = true
    }
    setAddresses(newAddresses)
  }

  const handleSetDefault = (id) => {
    api.get(`/address/default/${id}`)
      .then((res) => {
        toast.success("Default address changed")
        setUserData(res.data)
        setAddresses(res.data.addresses)
      })
      .catch((err) => {
        console.error(err)
      })
  }

  const handleEditClick = (address) => {
    setFormData(address)
    setEditingId(address.id)
    setShowAddForm(true)
  }

  const resetForm = () => {
    setFormData({})
    setEditingId(null)
    setShowAddForm(false)
  }

  const inputClasses = "h-11 w-full rounded-lg border border-input bg-background px-4 text-sm outline-none transition-colors focus:border-primary focus:ring-0 focus:ring-ring"

  return (
    <div className="flex min-h-screen flex-col bg-background pt-18.75">

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
                Manage Addresses
              </h1>
              <p className="mt-2 text-muted-foreground">
                Add and manage delivery addresses for faster checkout
              </p>
            </div>
            {!showAddForm && (
              <Button onClick={() => setShowAddForm(true)} className="gap-2">
                <Plus className="h-4 w-4" />
                Add Address
              </Button>
            )}
          </div>

          {/* Add Form */}
          {showAddForm && !editingId && (
            <div className="mt-6 rounded-2xl border border-border/60 bg-card p-6">
              <h2 className="font-semibold text-foreground" style={{ fontFamily: 'var(--font-heading)' }}>
                Add New Address
              </h2>
              <div className="mt-6 grid gap-4 sm:grid-cols-2">
                <FormField label="Address Name (e.g., Home, Work)" required className="sm:col-span-2">
                  <input
                    type="text"
                    name="addr_name"
                    value={formData.addr_name}
                    onChange={handleInputChange}
                    placeholder="Home"
                    className={inputClasses}
                    required
                  />
                </FormField>
                <FormField label="First Name" required>
                  <input
                    type="text"
                    name="f_name"
                    value={formData.f_name}
                    onChange={handleInputChange}
                    placeholder="John"
                    className={inputClasses}
                  />
                </FormField>
                <FormField label="Last Name" required>
                  <input
                    type="text"
                    name="l_name"
                    value={formData.l_name}
                    onChange={handleInputChange}
                    placeholder="Doe"
                    className={inputClasses}
                  />
                </FormField>
                <FormField label="Street Address" required className="sm:col-span-2">
                  <input
                    type="text"
                    name="address1"
                    value={formData.address1}
                    onChange={handleInputChange}
                    placeholder="123 Main Street"
                    className={inputClasses}
                    required
                  />
                </FormField>
                <FormField label="Apartment, Suite, etc.(Optional)" className="sm:col-span-2">
                  <input
                    type="text"
                    name="address2"
                    value={formData.address2}
                    onChange={handleInputChange}
                    placeholder="Apartment 4B"
                    className={inputClasses}
                  />
                </FormField>
                <FormField label="City" required>
                  <input
                    type="text"
                    name="city"
                    value={formData.city}
                    onChange={handleInputChange}
                    placeholder="San Francisco"
                    className={inputClasses}
                    required
                  />
                </FormField>
                <FormField label="State" star>
                  <select
                    name="state"
                    value={formData.state}
                    onChange={handleInputChange}
                    className={inputClasses}
                  >
                    <option value="">Select State</option>
                    {states.map((state) => (
                      <option key={state.code} value={state.code}>
                        {state.name}
                      </option>
                    ))}
                  </select>
                </FormField>
                <FormField label="Phone Number" required>
                  <input
                    type="tel"
                    name="phone"
                    value={formData.phone}
                    onChange={handleInputChange}
                    placeholder="+1 (555) 123-4567"
                    className={inputClasses}
                    required
                  />
                </FormField>
                <FormField label="ZIP Code" required>
                  <input
                    type="text"
                    name="postcode"
                    value={formData.postcode}
                    onChange={handleInputChange}
                    placeholder="94102"
                    className={inputClasses}
                    required
                  />
                </FormField>
              </div>
              <div className="mt-6 flex items-center justify-end gap-3">
                <Button variant="outline" onClick={resetForm}>
                  Cancel
                </Button>
                <Button onClick={handleAddAddress}>
                  Add Address
                </Button>
              </div>
            </div>
          )}

          {/* Addresses List */}
          <div className="mt-6 space-y-3">
            {addresses.length > 0 ? (
              <>
                {addresses.map((address) => (
                  <div key={address.id}>
                    {editingId === address.id ? (
                      <div className="relative rounded-xl border bg-card p-6 transition-all hover:border-primary/30 hover:shadow-sm">
                        <h2 className="font-semibold text-foreground" style={{ fontFamily: 'var(--font-heading)' }}>
                          Edit Address
                        </h2>
                        <div className="mt-6 grid gap-4 sm:grid-cols-2">
                          <FormField label="Address Name (e.g., Home, Work)" required className="sm:col-span-2">
                            <input
                              type="text"
                              name="addr_name"
                              value={formData.addr_name}
                              onChange={handleInputChange}
                              placeholder="Home"
                              className={inputClasses}
                              required
                            />
                          </FormField>
                          <FormField label="First Name" required>
                            <input
                              type="text"
                              name="f_name"
                              value={formData.f_name}
                              onChange={handleInputChange}
                              placeholder="John"
                              className={inputClasses}
                            />
                          </FormField>
                          <FormField label="Last Name" required>
                            <input
                              type="text"
                              name="l_name"
                              value={formData.l_name}
                              onChange={handleInputChange}
                              placeholder="Doe"
                              className={inputClasses}
                            />
                          </FormField>
                          <FormField label="Street Address" required className="sm:col-span-2">
                            <input
                              type="text"
                              name="address1"
                              value={formData.address1}
                              onChange={handleInputChange}
                              placeholder="123 Main Street"
                              className={inputClasses}
                              required
                            />
                          </FormField>
                          <FormField label="Apartment, Suite, etc.(Optional)" className="sm:col-span-2">
                            <input
                              type="text"
                              name="address2"
                              value={formData.address2}
                              onChange={handleInputChange}
                              placeholder="Apartment 4B"
                              className={inputClasses}
                            />
                          </FormField>
                          <FormField label="City" required>
                            <input
                              type="text"
                              name="city"
                              value={formData.city}
                              onChange={handleInputChange}
                              placeholder="San Francisco"
                              className={inputClasses}
                              required
                            />
                          </FormField>
                          <FormField label="State" star>
                            <select
                              name="state"
                              value={formData.state}
                              onChange={handleInputChange}
                              className={inputClasses}
                            >
                              <option value="">Select State</option>
                              {states.map((state) => (
                                <option key={state.code} value={state.code}>
                                  {state.name}
                                </option>
                              ))}
                            </select>
                          </FormField>
                          <FormField label="Phone Number" required>
                            <input
                              type="tel"
                              name="phone"
                              value={formData.phone}
                              onChange={handleInputChange}
                              placeholder="+1 (555) 123-4567"
                              className={inputClasses}
                              required
                            />
                          </FormField>
                          <FormField label="ZIP Code" required>
                            <input
                              type="text"
                              name="postcode"
                              value={formData.postcode}
                              onChange={handleInputChange}
                              placeholder="94102"
                              className={inputClasses}
                              required
                            />
                          </FormField>
                        </div>
                        <div className="mt-6 flex items-center justify-end gap-3">
                          <Button variant="outline" onClick={resetForm}>
                            Cancel
                          </Button>
                          <Button onClick={handleUpdateAddress}>
                            Update Address
                          </Button>
                        </div>
                      </div>
                    ) : (
                      <div
                        key={address.id}
                        className={cn(
                          "relative rounded-xl border bg-card p-6 transition-all hover:border-primary/30 hover:shadow-sm",
                          address.is_default ? "border-primary/50" : "border-border/60"
                        )}
                      >
                        {address.is_default != 0 && (
                          <div className="absolute right-6 top-6">
                            <span className="inline-flex items-center gap-1 rounded-full bg-primary/10 px-3 py-1 text-xs font-medium text-primary">
                              <Check className="h-3 w-3" />
                              Default
                            </span>
                          </div>
                        )}
                        {!address.is_default && (
                          <div className="absolute right-6 top-6">
                            <Button
                              size="sm"
                              variant="outline"
                              onClick={() => handleSetDefault(address.id)}
                              className="text-xs"
                            >
                              Set Default
                            </Button>
                          </div>
                        )}

                        <div className="flex items-start gap-4 pr-32">
                          <div className="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-muted">
                            <MapPin className="h-5 w-5 text-muted-foreground" />
                          </div>
                          <div className="flex-1">
                            <h3 className="font-semibold text-foreground">{address.addr_name || 'Home'}</h3>
                            <p className="mt-1 text-sm text-muted-foreground">
                              <span className="font-bold mb-1 block">{address.f_name} {address.l_name}</span>
                              {address.address1}
                              {address.locality && `, ${address.locality}`}
                            </p>
                            <p className="text-sm text-muted-foreground">
                              {address.city}, {address.state} {address.postcode}
                            </p>
                            <p className="text-sm text-muted-foreground">India</p>
                            <p className="mt-2 text-sm text-muted-foreground">+91 {address.phone}</p>
                          </div>
                        </div>

                        {/* Actions */}
                        <div className="absolute right-6 top-20 flex items-center gap-2">
                          <Button
                            size="sm"
                            variant="outline"
                            onClick={() => handleEditClick(address)}
                            className="gap-2"
                          >
                            <Edit2 className="h-4 w-4" />
                          </Button>
                          <Button
                            size="sm"
                            variant="outline"
                            onClick={() => handleDeleteAddress(address.id)}
                            className="text-destructive hover:bg-destructive/10"
                          >
                            <Trash2 className="h-4 w-4" />
                          </Button>
                        </div>
                      </div>
                    )}

                  </div>
                ))}
              </>
            ) : (
              <div>Loading ...</div>
            )}
          </div>
        </div>
      </main>

    </div>
  )
}
