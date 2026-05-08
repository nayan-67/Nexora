import { useState } from "react"
import { Link, useNavigate } from "react-router-dom"
import { ChevronLeft, Camera, Trash2, Check } from "lucide-react"
import { Button } from "@/components/ui/button"
import { cn } from "@/lib/utils"

const initialData = {
  firstName: "Sarah",
  lastName: "Anderson",
  email: "sarah.anderson@example.com",
  phone: "+1 (555) 123-4567",
  avatar: "https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=200&h=200&fit=crop&q=80",
  street: "123 Innovation Boulevard",
  apartment: "Suite 400",
  city: "San Francisco",
  state: "CA",
  zip: "94102",
  country: "United States",
}

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

export default function EditProfilePage() {
  const navigate = useNavigate()
  const [formData, setFormData] = useState(initialData)
  const [isSaving, setIsSaving] = useState(false)
  const [showSuccess, setShowSuccess] = useState(false)

  const handleInputChange = (e) => {
    const { name, value } = e.target
    setFormData(prev => ({ ...prev, [name]: value }))
  }

  const handleSubmit = async (e) => {
    e.preventDefault()
    setIsSaving(true)
    await new Promise(resolve => setTimeout(resolve, 1500))
    setIsSaving(false)
    setShowSuccess(true)
    setTimeout(() => {
      setShowSuccess(false)
      navigate("/profile")
    }, 1500)
  }

  const inputClasses = "h-11 w-full rounded-lg border border-input bg-background px-4 text-sm outline-none transition-colors focus:border-primary focus:ring-2 focus:ring-ring"

  return (
    <div className="flex min-h-screen flex-col bg-background pt-18.75">
      {/* <Header /> */}

      <main className="flex-1">
        <div className="mx-auto max-w-2xl px-4 py-8 sm:px-6 lg:px-8">
          {/* Back Link */}
          <Link
            to="/profile"
            className="inline-flex items-center gap-2 text-sm text-muted-foreground transition-colors hover:text-foreground"
          >
            <ChevronLeft className="h-4 w-4" />
            Back to Profile
          </Link>

          <h1 className="mt-6 text-3xl font-bold tracking-tight text-foreground" style={{ fontFamily: 'var(--font-heading)' }}>
            Edit Profile
          </h1>
          <p className="mt-2 text-muted-foreground">
            Update your personal information and preferences
          </p>

          {/* Success Toast */}
          {showSuccess && (
            <div className="fixed right-4 top-20 z-50 flex items-center gap-2 rounded-lg bg-green-600 px-4 py-3 text-white shadow-lg">
              <Check className="h-5 w-5" />
              <span className="font-medium">Profile updated successfully!</span>
            </div>
          )}

          <form onSubmit={handleSubmit} className="mt-8 space-y-8">
            {/* Avatar Section */}
            <div className="rounded-2xl border border-border/60 bg-card p-6">
              <h2 className="font-semibold text-foreground" style={{ fontFamily: 'var(--font-heading)' }}>
                Profile Photo
              </h2>
              <div className="mt-4 flex items-center gap-6">
                <div className="relative">
                  <img
                    src={formData.avatar}
                    alt="Profile"
                    className="h-24 w-24 rounded-2xl object-cover"
                  />
                  <button
                    type="button"
                    className="absolute -bottom-2 -right-2 flex h-8 w-8 items-center justify-center rounded-full bg-primary text-primary-foreground shadow-lg transition-transform hover:scale-110"
                  >
                    <Camera className="h-4 w-4" />
                  </button>
                </div>
                <div className="space-y-2">
                  <Button type="button" variant="outline" size="sm">
                    Upload New Photo
                  </Button>
                  <p className="text-xs text-muted-foreground">
                    JPG, PNG or GIF. Max size 5MB.
                  </p>
                </div>
              </div>
            </div>

            {/* Personal Information */}
            <div className="rounded-2xl border border-border/60 bg-card p-6">
              <h2 className="font-semibold text-foreground" style={{ fontFamily: 'var(--font-heading)' }}>
                Personal Information
              </h2>
              <div className="mt-6 grid gap-4 sm:grid-cols-2">
                <FormField label="First Name" required>
                  <input
                    type="text"
                    name="firstName"
                    value={formData.firstName}
                    onChange={handleInputChange}
                    className={inputClasses}
                    required
                  />
                </FormField>
                <FormField label="Last Name" required>
                  <input
                    type="text"
                    name="lastName"
                    value={formData.lastName}
                    onChange={handleInputChange}
                    className={inputClasses}
                    required
                  />
                </FormField>
                <FormField label="Email Address" required className="sm:col-span-2">
                  <input
                    type="email"
                    name="email"
                    value={formData.email}
                    onChange={handleInputChange}
                    className={inputClasses}
                    required
                  />
                </FormField>
                <FormField label="Phone Number" className="sm:col-span-2">
                  <input
                    type="tel"
                    name="phone"
                    value={formData.phone}
                    onChange={handleInputChange}
                    className={inputClasses}
                  />
                </FormField>
              </div>
            </div>

            {/* Address */}
            <div className="rounded-2xl border border-border/60 bg-card p-6">
              <h2 className="font-semibold text-foreground" style={{ fontFamily: 'var(--font-heading)' }}>
                Default Address
              </h2>
              <div className="mt-6 grid gap-4 sm:grid-cols-2">
                <FormField label="Street Address" className="sm:col-span-2">
                  <input
                    type="text"
                    name="street"
                    value={formData.street}
                    onChange={handleInputChange}
                    className={inputClasses}
                  />
                </FormField>
                <FormField label="Apartment, Suite, etc." className="sm:col-span-2">
                  <input
                    type="text"
                    name="apartment"
                    value={formData.apartment}
                    onChange={handleInputChange}
                    className={inputClasses}
                  />
                </FormField>
                <FormField label="City">
                  <input
                    type="text"
                    name="city"
                    value={formData.city}
                    onChange={handleInputChange}
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
                      className={inputClasses}
                    />
                  </FormField>
                  <FormField label="ZIP Code">
                    <input
                      type="text"
                      name="zip"
                      value={formData.zip}
                      onChange={handleInputChange}
                      className={inputClasses}
                    />
                  </FormField>
                </div>
                <FormField label="Country" className="sm:col-span-2">
                  <select
                    name="country"
                    value={formData.country}
                    onChange={handleInputChange}
                    className={inputClasses}
                  >
                    <option>United States</option>
                    <option>Canada</option>
                    <option>United Kingdom</option>
                    <option>Australia</option>
                    <option>Germany</option>
                    <option>France</option>
                  </select>
                </FormField>
              </div>
            </div>

            {/* Danger Zone */}
            <div className="rounded-2xl border border-destructive/30 bg-destructive/5 p-6">
              <h2 className="font-semibold text-destructive" style={{ fontFamily: 'var(--font-heading)' }}>
                Danger Zone
              </h2>
              <p className="mt-2 text-sm text-muted-foreground">
                Once you delete your account, there is no going back. Please be certain.
              </p>
              <Button
                type="button"
                variant="outline"
                size="sm"
                className="mt-4 gap-2 border-destructive text-destructive hover:bg-destructive hover:text-white cursor-pointer"
              >
                <Trash2 className="h-4 w-4" />
                Delete Account
              </Button>
            </div>

            {/* Actions */}
            <div className="flex items-center justify-end gap-4">
              <Button
                type="button"
                variant="outline"
                className="cursor-pointer"
                onClick={() => navigate("/profile")}
              >
                Cancel
              </Button>
              <Button type="submit" disabled={isSaving} className="cursor-pointer">
                {isSaving ? "Saving..." : "Save Changes"}
              </Button>
            </div>
          </form>
        </div>
      </main>

      {/* <Footer /> */}
    </div>
  )
}
