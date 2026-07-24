import { useContext, useEffect, useState } from "react"
import { Link, useNavigate } from "react-router-dom"
import { ChevronLeft, CreditCard, Lock, Check, Truck, X, LoaderCircle } from "lucide-react"
import { Button } from "@/components/ui/button"
import { ShinyText } from "@/components/lightswind/shiny-text"
import { cn } from "@/lib/utils"
import { states } from "@/lib/state"
import api from "@/lib/api"
import { toast } from "react-hot-toast";
import { CartContext } from "@/context/CartContext"
const apiBase = api.defaults.baseURL.replace(/\/api\/?$/, "")

function PrdCard({ item, prd, variants, order }) {
  const isVariant = item.prd_type == 2
  const prdDetails = prd?.find((p) => Number(p.id) === Number(item.prd_id))
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

  if (!displayData) {
    return (
      <div className="flex gap-4 border-b border-border/40 py-6 first:pt-0 last:border-0 pt-18.75">
        <div className="h-14 w-14 overflow-hidden rounded-lg bg-muted animate-pulse"></div>
        <div className="flex-1">
          <div className="h-4 bg-gray-300 rounded animate-pulse w-3/4"></div>
          <div className="h-4 bg-gray-300 rounded animate-pulse w-1/2 mt-2"></div>
        </div>
      </div>
    )
  }

  if (order) {
    return (
      <div key={item.prd_id} className="flex items-center gap-3">
        <div className="h-12 w-12 overflow-hidden rounded-lg bg-muted">
          <img src={`${apiBase}/uploads/${imageType}_sm_${displayData?.featured_image}`} alt={item.name} className="h-full w-full object-cover" />
        </div>
        <div className="flex-1">
          <p className="text-sm font-medium text-foreground">{prdDetails?.name} {name.length != 0 ? `(${name.join(',')})` : ''}</p>
          <p className="text-xs text-muted-foreground">Qty: {item.quantity}</p>
        </div>
        <p className="text-sm font-medium text-foreground">
          ₹ {(displayData?.sale_price ?? displayData?.price) * item.quantity.toFixed(2)}
        </p>
      </div>
    )
  }

  return (
    <div key={item.prd_id} className="flex items-center gap-3">
      <div className="relative h-14 w-14">
        <img src={`${apiBase}/uploads/${imageType}_sm_${displayData?.featured_image}`} alt={prdDetails?.name} className="h-full w-full object-cover rounded-lg" />
        <span className="absolute -right-1 -top-1 flex h-5 w-5 items-center justify-center rounded-full bg-primary text-xs font-medium text-primary-foreground">
          {item.quantity}
        </span>
      </div>
      <div className="flex-1">
        <p className="text-sm font-medium text-foreground line-clamp-1">{prdDetails?.name} {name.length != 0 ? `(${name.join(',')})` : ''}</p>
        <p className="text-sm text-muted-foreground">₹ {(displayData?.sale_price ?? displayData?.price)}</p>
      </div>
    </div>
  )
}

const steps = [
  { id: 1, name: "Shipping" },
  { id: 2, name: "Billing" },
  { id: 3, name: "Payment" },
  { id: 4, name: "Review" },
]

function FormField({ label, children, className, star }) {
  return (
    <div className={cn("space-y-2", className)}>
      <label className="text-sm font-medium text-foreground">{label}<span className="text-red-500 ms-1">{star ? '*' : ''}</span></label>
      {children}
    </div>
  )
}

export default function CheckoutPage() {
  const navigate = useNavigate()
  const [currentStep, setCurrentStep] = useState(1)
  const [isProcessing, setIsProcessing] = useState(false)
  const [isAddrProcessing, setIsAddrProcessing] = useState(false)
  const [sameAsShipping, setSameAsShipping] = useState(false)
  const [saveCardInfo, setSaveCardInfo] = useState(false)
  const [products, setProducts] = useState([])
  const [variants, setVariants] = useState([])
  const [addresses, setAddresses] = useState([])
  const [shippingAddress, setShippingAddress] = useState([])
  const [billingAddress, setBillingAddress] = useState([])
  const [showShipAddrMenu, setShowShipAddrMenu] = useState(false)
  const [showBillAddrMenu, setShowBillAddrMenu] = useState(false)
  const [showNewAddrModal, setShowNewAddrModal] = useState(false)
  const { cartData, setCartData } = useContext(CartContext)
  const [formData, setFormData] = useState({
    firstName: "",
    lastName: "",
    address: "",
    locality: "",
    city: "",
    state: "",
    zipCode: "",
    phone: "",
    billingFirstName: "",
    billingLastName: "",
    billingAddress: "",
    billingLocality: "",
    billingCity: "",
    billingState: "",
    billingZipCode: "",
    billingPhone: "",
    country: "India",
    cardNumber: "",
    cardName: "",
    expiry: "",
    cvv: "",
    paymentMethod: "",
    saveInfo: saveCardInfo,
    sameAsShipping: sameAsShipping,
    orderData: {},
    shipId: null,
    billId: null,
  })
  const [newAddrForm, setNewAddrForm] = useState({
    firstName: "",
    lastName: "",
    address: "",
    locality: "",
    city: "",
    state: "",
    zipCode: "",
    phone: "",
  })

  useEffect(() => {
    let active = true;

    const loadCatVarData = async () => {
      try {
        const [variantResponse, productResponse, addressResponse] = await Promise.all([
          api.get("/product/variants"),
          api.get("/products"),
          api.get("/address")
        ])

        if (!active) return

        setVariants(variantResponse.status === 200 ? variantResponse.data : [])
        setProducts(productResponse.status === 200 ? productResponse.data : [])
        setAddresses(addressResponse.status === 200 ? addressResponse.data : [])
      } catch (error) {
        if (!active) return

        setVariants([])
        setProducts([])
        setAddresses([])
        console.error("Error fetching data:", error)
      }
    }

    loadCatVarData()

    return () => {
      active = false;
    };
  }, []);

  useEffect(() => {
    if (addresses.length > 0) {
      const defaultAddr = addresses.find(address => address.is_default === 1);
      if (defaultAddr) {
        setShippingAdd(defaultAddr.id)
        setBillingAdd(defaultAddr.id)
      }
    }
  }, [addresses]);

  const subtotal = cartData.reduce((sum, item) => {
    const isVariant = item.prd_type == 2
    const prdDetails = products?.find((p) => Number(p.id) === Number(item.prd_id))
    const variantDetails = isVariant && variants?.find((v) => v.sku == item.sku)
    const displayData = isVariant ? variantDetails : prdDetails
    return sum + ((displayData?.sale_price || displayData?.price) * item.quantity || 0)
  }, 0)
  const coupon = JSON.parse(sessionStorage.getItem("coupon"))
  const discount = coupon ? (coupon.type == 2 ? Number(coupon.amount) : subtotal * (coupon.amount / 100)) : 0
  const shipping = subtotal > 500 ? 0 : 40
  const tax = subtotal * 0.08
  const total = subtotal + shipping + tax - discount

  const handleInputChange = (e) => {
    const { name, value, type, checked } = e.target
    setFormData(prev => ({
      ...prev,
      [name]: type === "checkbox" ? checked : value
    }))
  }
  const handleNewInputChange = (e) => {
    const { name, value, type, checked } = e.target
    setNewAddrForm(prev => ({
      ...prev,
      [name]: type === "checkbox" ? checked : value
    }))
  }

  const handleSubmit = async (e) => {
    if (currentStep < 4) {
      setCurrentStep(currentStep + 1)
    } else {
      e.preventDefault()
      setIsProcessing(true)
      const orderData = {
        items: cartData,
        tax: tax,
        shipping: shipping,
        discount: discount,
        subtotal: subtotal,
        total: total,
        coupon: coupon ? coupon : null
      }
      const updatedFormData = { ...formData, orderData: orderData }
      await new Promise(resolve => {
        api.post("/order/create", updatedFormData)
          .then((res) => {
            resolve
            if (res.status == 201) {
              sessionStorage.removeItem("coupon")
              setCartData([])
              navigate(`/checkout/success/${res.data}`)
            } else {
              toast.error("Something went wrong!.");
            }
          })
          .catch((err) => {
            console.error(err)
            toast.error("Something went wrong!.");
          })
          .finally(() => setIsProcessing(false))
      })
    }
  }
  const saveNewAddress = async (e) => {
    e.preventDefault()
    setIsAddrProcessing(true)
    await new Promise(resolve => {
      api.post("/address/create", newAddrForm)
        .then((res) => {
          resolve
          setAddresses(res.data)
          setShowNewAddrModal(!showNewAddrModal)
          newAddrForm.firstName = ""
          newAddrForm.lastName = ""
          newAddrForm.address = ""
          newAddrForm.locality = ""
          newAddrForm.city = ""
          newAddrForm.state = ""
          newAddrForm.zipCode = ""
          newAddrForm.phone = ""
          toast.success("New Address Saved")
        })
        .catch((err) => {
          console.error(err)
          toast.error("Something went wrong!.");
        })
        .finally(() => setIsAddrProcessing(false))
    })
  }
  const setShippingAdd = (id) => {
    api.get(`/address/${id}`)
      .then((res) => {
        setShippingAddress(res.data)
        setFormData(prev => ({ ...prev, shipId: id }))
      })
  }
  const setBillingAdd = (id) => {
    api.get(`/address/${id}`)
      .then((res) => {
        setBillingAddress(res.data)
        setFormData(prev => ({ ...prev, billId: id }))
      })
  }

  const inputClasses = "h-11 w-full rounded-lg border border-input bg-background px-4 text-sm outline-none transition-colors focus:border-primary focus:ring-0 focus:ring-ring"

  return (
    <div className="flex min-h-screen flex-col bg-background pt-18.75">

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

          {/* Add Address Modal */}
          {showNewAddrModal && (
            <div className="new-address fixed top-0 left-0 flex items-center justify-center min-h-screen w-full z-49 backdrop-blur-sm">
              <div className="mt-22 border border-violet-500 backdrop-blur-2xl rounded-xl bg-white transition-opacity relative">
                <X className="absolute -top-3 -right-3 z-80 border border-violet-600 rounded-full text-red-500 bg-white cursor-pointer" onClick={() => {
                  setShowNewAddrModal(!showNewAddrModal)
                  newAddrForm.firstName = ""
                  newAddrForm.lastName = ""
                  newAddrForm.address = ""
                  newAddrForm.locality = ""
                  newAddrForm.city = ""
                  newAddrForm.state = ""
                  newAddrForm.zipCode = ""
                  newAddrForm.phone = ""
                }} />
                {/* <h2 className="col-span-2">Add New Address</h2> */}
                <div className="w-[99%] sticky top-0 col-span-2 bg-white pt-5 pb-2 ps-5 rounded-t-xl border-b border-b-muted border-r-violet-500">
                  <ShinyText baseColor="oklch(0.13 0.02 280)"
                    shineColor="rgba(147, 51, 234, 0.9)"
                    shineWidth={1}
                    size="3xl"
                    weight="bold"
                    speed={3}>Add New Address</ShinyText>
                </div>
                <div className="h-100 mt-2 grid gap-4 sm:grid-cols-2 overflow-y-scroll ps-5 pe-4 pb-5 custom-thumb">
                  <FormField label="First Name" star>
                    <input
                      type="text"
                      name="firstName"
                      value={newAddrForm.firstName}
                      onChange={handleNewInputChange}
                      placeholder="John"
                      className={inputClasses}
                    />
                  </FormField>
                  <FormField label="Last Name" star>
                    <input
                      type="text"
                      name="lastName"
                      value={newAddrForm.lastName}
                      onChange={handleNewInputChange}
                      placeholder="Doe"
                      className={inputClasses}
                    />
                  </FormField>
                  <FormField label="Address" className="sm:col-span-2" star>
                    <input
                      type="text"
                      name="address"
                      value={newAddrForm.address}
                      onChange={handleNewInputChange}
                      placeholder="123 Main Street, Apt 4"
                      className={inputClasses}
                    />
                  </FormField>
                  <FormField label="Locality (Optional)" className="sm:col-span-2">
                    <input
                      type="text"
                      name="locality"
                      value={newAddrForm.locality}
                      onChange={handleNewInputChange}
                      placeholder="123 Main Street, Apt 4"
                      className={inputClasses}
                    />
                  </FormField>
                  <FormField label="City" star>
                    <input
                      type="text"
                      name="city"
                      value={newAddrForm.city}
                      onChange={handleNewInputChange}
                      placeholder="Kolkata"
                      className={inputClasses}
                    />
                  </FormField>
                  <FormField label="State" star>
                    <select
                      name="state"
                      value={newAddrForm.state}
                      onChange={handleNewInputChange}
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
                  <FormField label="Phone" star>
                    <input
                      type="tel"
                      name="phone"
                      value={newAddrForm.phone}
                      onChange={handleNewInputChange}
                      placeholder="+91 12345-67890"
                      className={inputClasses}
                    />
                  </FormField>
                  <FormField label="ZIP Code" star>
                    <input
                      type="text"
                      name="zipCode"
                      value={newAddrForm.zipCode}
                      onChange={handleNewInputChange}
                      placeholder="100001"
                      className={inputClasses}
                    />
                  </FormField>
                  <div className="flex justify-end col-span-2">
                    <Button onClick={saveNewAddress} disabled={isAddrProcessing}>
                      {isAddrProcessing ?
                        <span className="flex items-center gap-2 pointer-events-none">
                          <LoaderCircle className="animate-spin h-4 w-4" />
                          Saving ..
                        </span> : <>
                          Save</>
                      }
                    </Button>
                  </div>
                </div>
              </div>
            </div>
          )}

          <div className="mt-8 grid gap-8 lg:grid-cols-3">
            {/* Form */}
            <div className="lg:col-span-2">
              <div className="rounded-2xl border border-border/60 bg-card p-6">
                {/* Step 1: Shipping */}
                {currentStep === 1 && (
                  <div className="relative">
                    <div className="flex items-center justify-between">
                      <h2 className="text-xl font-semibold text-foreground" style={{ fontFamily: 'var(--font-heading)' }}>
                        Shipping Information
                      </h2>
                      {addresses.length > 0 && (
                        <button onClick={() => { setShowShipAddrMenu(!showShipAddrMenu) }} className="text-primary text-sm hover:underline cursor-pointer outline-none-important">Change</button>
                      )}
                    </div>
                    {showShipAddrMenu && (
                      <>
                        <div className="fixed inset-0 z-30" onClick={() => setShowShipAddrMenu(false)} />
                        <div className="absolute right-0 top-10 z-31 mt-2 w-80 rounded-xl border border-border bg-card p-3 shadow-lg">
                          {addresses.map(item => (
                            <button
                              key={item.id}
                              onClick={() => {
                                setShippingAdd(item.id)
                                setShowShipAddrMenu(false)
                              }}
                              className={cn(
                                "flex flex-col items-baseline w-full rounded-lg px-3 py-2 text-sm transition-colors cursor-pointer border mb-2",
                                shippingAddress.id === item.id
                                  ? "border-primary"
                                  : "text-foreground hover:bg-accent"
                              )}
                            >
                              <p className="font-bold mb-2">{item.f_name} {item.l_name}</p>
                              <p>{item.address2}</p>
                              <p>{item.address1}</p>
                              <p>{item.city}, {item.state} {item.postcode}</p>
                              <p className="mt-2">{shippingAddress.phone}</p>
                            </button>
                          ))}
                          {/* <Button>Add New</Button> */}
                          <div className="flex justify-end">
                            <button className="mt-2 px-3 text-sm text-[#4e3fd3] hover:border-primary transition-all rounded-xl border border-border bg-card p-1 shadow-lg" onClick={() => {
                              setShowNewAddrModal(!showNewAddrModal)
                              setShowShipAddrMenu(!showShipAddrMenu)
                            }}>Add New</button>
                          </div>
                        </div>
                      </>
                    )}
                    {addresses.length > 0 ? (
                      <div className="mt-6 grid gap-4 sm:grid-cols-2">
                        <div className="address">
                          <div className="text-sm text-muted-foreground">
                            <p className="font-bold mb-2">{shippingAddress.f_name} {shippingAddress.l_name}</p>
                            {shippingAddress.address2}<br />
                            {shippingAddress.address1}<br />
                            {shippingAddress.city}, {shippingAddress.state} {shippingAddress.postcode}<br />
                            <p className="mt-2">{shippingAddress.phone}</p><br />
                          </div>
                        </div>
                      </div>
                    ) : (
                      <div className="mt-6 grid gap-4 sm:grid-cols-2">
                        <FormField label="First Name" star>
                          <input
                            type="text"
                            name="firstName"
                            value={formData.firstName}
                            onChange={handleInputChange}
                            placeholder="John"
                            className={inputClasses}
                          />
                        </FormField>
                        <FormField label="Last Name" star>
                          <input
                            type="text"
                            name="lastName"
                            value={formData.lastName}
                            onChange={handleInputChange}
                            placeholder="Doe"
                            className={inputClasses}
                          />
                        </FormField>
                        {/* <FormField label="Email" className="sm:col-span-2" star>
                        <input
                          type="email"
                          name="email"
                          value={formData.email}
                          onChange={handleInputChange}
                          placeholder="you@example.com"
                          className={inputClasses}
                        />
                      </FormField> */}
                        <FormField label="Address" className="sm:col-span-2" star>
                          <input
                            type="text"
                            name="address"
                            value={formData.address}
                            onChange={handleInputChange}
                            placeholder="123 Main Street, Apt 4"
                            className={inputClasses}
                          />
                        </FormField>
                        <FormField label="Locality (Optional)" className="sm:col-span-2">
                          <input
                            type="text"
                            name="locality"
                            value={formData.locality}
                            onChange={handleInputChange}
                            placeholder="123 Main Street, Apt 4"
                            className={inputClasses}
                          />
                        </FormField>
                        <FormField label="City" star>
                          <input
                            type="text"
                            name="city"
                            value={formData.city}
                            onChange={handleInputChange}
                            placeholder="Kolkata"
                            className={inputClasses}
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
                        <FormField label="Phone" star>
                          <input
                            type="tel"
                            name="phone"
                            value={formData.phone}
                            onChange={handleInputChange}
                            placeholder="+91 00000-0000"
                            className={inputClasses}
                          />
                        </FormField>
                        <FormField label="ZIP Code" star>
                          <input
                            type="text"
                            name="zipCode"
                            value={formData.zipCode}
                            onChange={handleInputChange}
                            placeholder="100001"
                            className={inputClasses}
                          />
                        </FormField>
                      </div>
                    )}
                  </div>
                )}

                {/* Step 2: Billing */}
                {currentStep === 2 && (
                  <div className="relative">
                    <div className="flex items-center justify-between">
                      <h2 className="text-xl font-semibold text-foreground" style={{ fontFamily: 'var(--font-heading)' }}>
                        Billing Information
                      </h2>
                      <div className="flex items-end flex-col">
                        {addresses.length > 0 && (
                          <button onClick={() => { setShowBillAddrMenu(!showBillAddrMenu) }} className="text-primary text-sm hover:underline cursor-pointer outline-none-important mt-3">Change Address</button>
                        )}
                        <div className="flex items-center gap-2 mt-1">
                          <input type="checkbox" className="text-md" name="sameasshipping" id="sameasshipping" checked={sameAsShipping} onChange={() => {
                            setSameAsShipping(!sameAsShipping)
                            setFormData(prev => ({ ...prev, sameAsShipping: !sameAsShipping }))
                          }}
                          />
                          {/* {sameAsShipping ? (
                          ) : (
                            <input type="checkbox" className="text-md" name="sameasshipping" id="sameasshipping" onClick={() => {
                              setSameAsShipping(!sameAsShipping)
                              setFormData(prev => ({ ...prev, sameAsShipping: !sameAsShipping }))
                            }}
                            />
                          )} */}
                          <label htmlFor="sameasshipping" className="text-md font-medium text-foreground">Same as Shipping</label>
                        </div>
                      </div>
                    </div>
                    {showBillAddrMenu && (
                      <>
                        <div className="fixed inset-0 z-30" onClick={() => setShowBillAddrMenu(false)} />
                        <div className="absolute right-0 top-10 z-31 mt-2 w-80 rounded-xl border border-border bg-card p-3 shadow-lg">
                          {addresses.map(item => (
                            <button
                              key={item.id}
                              onClick={() => {
                                setBillingAdd(item.id)
                                setShowBillAddrMenu(false)
                              }}
                              className={cn(
                                "flex flex-col items-baseline w-full rounded-lg px-3 py-2 text-sm transition-colors cursor-pointer border mb-2",
                                billingAddress.id === item.id
                                  ? "border-primary"
                                  : "text-foreground hover:bg-accent"
                              )}
                            >
                              <p className="font-bold mb-2">{item.f_name} {item.l_name}</p>
                              <p>{item.address2}</p>
                              <p>{item.address1}</p>
                              <p>{item.city}, {item.state} {item.postcode}</p>
                              <p className="mt-2">{shippingAddress.phone}</p>
                            </button>
                          ))}
                          <div className="flex justify-end">
                            <button className="mt-2 px-3 text-sm text-[#4e3fd3] hover:border-primary transition-all rounded-xl border border-border bg-card p-1 shadow-lg" onClick={() => {
                              setShowNewAddrModal(!showNewAddrModal)
                              setShowBillAddrMenu(!showBillAddrMenu)
                            }}>Add New</button>
                          </div>
                        </div>
                      </>
                    )}

                    {sameAsShipping ? (
                      <div className="mt-6 grid gap-4 sm:grid-cols-2">
                        <div className="address">
                          <div className="text-sm text-muted-foreground">
                            {addresses.length > 0 ? (
                              <>
                                <p className="font-bold mb-2">{shippingAddress.f_name} {shippingAddress.l_name}</p>
                                {shippingAddress.address2}<br />
                                {shippingAddress.address1}<br />
                                {shippingAddress.city}, {shippingAddress.state} {shippingAddress.postcode}<br />
                                <p className="mt-2">{shippingAddress.phone}</p><br />
                              </>
                            ) : (
                              <>
                                <p className="font-bold mb-2">{formData.firstName} {formData.lastName}</p>
                                {formData.locality}<br />
                                {formData.address}<br />
                                {formData.city}, {formData.state} {formData.zipCode}<br />
                                <p className="mt-2">{formData.phone}</p><br />
                              </>
                            )}
                          </div>
                        </div>
                      </div>
                    ) : (
                      <>
                        {
                          addresses.length > 0 ? (
                            <div className="mt-6 grid gap-4 sm:grid-cols-2">
                              <div className="address">
                                <div className="text-sm text-muted-foreground">
                                  <p className="font-bold mb-2">{billingAddress.f_name} {billingAddress.l_name}</p>
                                  {billingAddress.address2}<br />
                                  {billingAddress.address1}<br />
                                  {billingAddress.city}, {billingAddress.state} {billingAddress.postcode}<br />
                                  <p className="mt-2">{billingAddress.phone}</p><br />
                                </div>
                              </div>
                            </div>
                          ) : (<div>
                            <div className="mt-6 grid gap-4 sm:grid-cols-2">
                              <FormField label="First Name" star>
                                <input
                                  type="text"
                                  name="billingFirstName"
                                  value={formData.billingFirstName}
                                  onChange={handleInputChange}
                                  placeholder="John"
                                  className={inputClasses}
                                />
                              </FormField>
                              <FormField label="Last Name" star>
                                <input
                                  type="text"
                                  name="billingLastName"
                                  value={formData.billingLastName}
                                  onChange={handleInputChange}
                                  placeholder="Doe"
                                  className={inputClasses}
                                />
                              </FormField>
                              <FormField label="Address" className="sm:col-span-2" star>
                                <input
                                  type="text"
                                  name="billingAddress"
                                  value={formData.billingAddress}
                                  onChange={handleInputChange}
                                  placeholder="123 Main Street, Apt 4"
                                  className={inputClasses}
                                />
                              </FormField>
                              <FormField label="Locality (Optional)" className="sm:col-span-2">
                                <input
                                  type="text"
                                  name="billingLocality"
                                  value={formData.billingLocality}
                                  onChange={handleInputChange}
                                  placeholder="123 Main Street, Apt 4"
                                  className={inputClasses}
                                />
                              </FormField>
                              <FormField label="City" star>
                                <input
                                  type="text"
                                  name="billingCity"
                                  value={formData.billingCity}
                                  onChange={handleInputChange}
                                  placeholder="Kolkata"
                                  className={inputClasses}
                                />
                              </FormField>
                              <FormField label="State" star>
                                <select
                                  name="billingState"
                                  value={formData.billingState}
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
                              <FormField label="Phone" star>
                                <input
                                  type="tel"
                                  name="billingPhone"
                                  value={formData.billingPhone}
                                  onChange={handleInputChange}
                                  placeholder="+91 00000-0000"
                                  className={inputClasses}
                                />
                              </FormField>
                              <FormField label="ZIP Code" star>
                                <input
                                  type="text"
                                  name="billingZipCode"
                                  value={formData.billingZipCode}
                                  onChange={handleInputChange}
                                  placeholder="100001"
                                  className={inputClasses}
                                />
                              </FormField>
                            </div>
                          </div>
                          )}
                      </>
                    )}
                  </div>
                )}

                {/* Step 3: Payment */}
                {currentStep === 3 && (
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
                    <div className="mt-4 flex items-center justify-between gap-2 text-sm text-muted-foreground">
                      <div className="flex items-center gap-2">
                        <Lock className="h-4 w-4" />
                        Your payment information is encrypted and secure
                      </div>
                      <div className="flex items-center gap-2 my-3">
                        <input type="checkbox" className="text-md accent-accent-foreground" name="savecardinfo" id="savecardinfo" onClick={() => {
                          setSaveCardInfo(!saveCardInfo)
                          setFormData(prev => ({ ...prev, saveInfo: !saveCardInfo }))
                        }} />
                        <label htmlFor="savecardinfo" className="text-md font-medium text-muted-foreground">Save Card info</label>
                      </div>
                    </div>
                  </div>
                )}

                {/* Step 4: Review */}
                {currentStep === 4 && (
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
                      <div className="mt-2 text-sm text-muted-foreground">
                        {addresses.length > 0 ? (
                          <>
                            <p className="font-bold mb-2">{shippingAddress.f_name} {shippingAddress.l_name}</p>
                            {shippingAddress.address2}<br />
                            {shippingAddress.address1}<br />
                            {shippingAddress.city}, {shippingAddress.state} {shippingAddress.postcode}<br />
                            <p className="mt-2">{shippingAddress.phone}</p><br />
                          </>
                        ) : (
                          <>
                            <p className="font-bold mb-2">{formData.firstName} {formData.lastName}</p>
                            {formData.locality}<br />
                            {formData.address}<br />
                            {formData.city}, {formData.state} {formData.zipCode}<br />
                            <p className="mt-2">{formData.phone}</p><br />
                          </>
                        )}
                      </div>
                    </div>

                    {/* Billing Summary */}
                    <div className="mt-6 rounded-xl border border-border/60 p-4">
                      <div className="flex items-center justify-between">
                        <h3 className="font-medium text-foreground">Billing Address</h3>
                        <button
                          onClick={() => setCurrentStep(2)}
                          className="text-sm text-primary hover:underline"
                        >
                          Edit
                        </button>
                      </div>
                      <div className="mt-2 text-sm text-muted-foreground">
                        {sameAsShipping ? (
                          <>
                            {addresses.length > 0 ? (
                              <>
                                <p className="font-bold mb-2">{shippingAddress.f_name} {shippingAddress.l_name}</p>
                                {shippingAddress.address2}<br />
                                {shippingAddress.address1}<br />
                                {shippingAddress.city}, {shippingAddress.state} {shippingAddress.postcode}<br />
                                <p className="mt-2">{shippingAddress.phone}</p><br />
                              </>
                            ) : (
                              <>
                                <p className="font-bold mb-2">{formData.firstName} {formData.lastName}</p>
                                {formData.locality}<br />
                                {formData.address}<br />
                                {formData.city}, {formData.state} {formData.zipCode}<br />
                                <p className="mt-2">{formData.phone}</p><br />
                              </>
                            )}
                          </>
                        ) : (
                          <>
                            {addresses.length > 0 ? (
                              <>
                                <p className="font-bold mb-2">{billingAddress.f_name} {billingAddress.l_name}</p>
                                {billingAddress.address2}<br />
                                {billingAddress.address1}<br />
                                {billingAddress.city}, {billingAddress.state} {billingAddress.postcode}<br />
                                <p className="mt-2">{billingAddress.phone}</p><br />

                              </>
                            ) : (
                              <>
                                <p className="font-bold mb-2">{formData.billingFirstName} {formData.billingLastName}</p>
                                {formData.billingLocality}<br />
                                {formData.billingAddress}<br />
                                {formData.billingCity}, {formData.billingState} {formData.billingZipCode}<br />
                                <p className="mt-2">{formData.billingPhone}</p><br />
                              </>
                            )}
                          </>
                        )}
                      </div>
                    </div>

                    {/* Payment Summary */}
                    <div className="mt-4 rounded-xl border border-border/60 p-4">
                      <div className="flex items-center justify-between">
                        <h3 className="font-medium text-foreground">Payment Method</h3>
                        <button
                          onClick={() => setCurrentStep(3)}
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
                        {cartData.map((item) => (
                          <PrdCard key={item.id} item={item} prd={products} variants={variants} order={true} />
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
                    ) : currentStep === 4 ? (
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
                  {cartData.map((item) => (
                    <PrdCard key={item.id} item={item} prd={products} variants={variants} />
                  ))}
                </div>

                <div className="mt-6 space-y-3 border-t border-border/40 pt-6">
                  <div className="flex justify-between text-sm">
                    <span className="text-muted-foreground">Subtotal</span>
                    <span className="text-foreground">₹ {subtotal.toFixed(2)}</span>
                  </div>
                  {discount != 0 && (
                    <div className="flex justify-between text-sm">
                      <span className="text-green-600">Discount ({coupon.type == 2 ? `₹ ${coupon.amount}` : `${coupon.amount}%`})</span>
                      <span className="text-green-600">-₹ {discount.toFixed(2)}</span>
                    </div>
                  )}
                  <div className="flex justify-between text-sm">
                    <span className="text-muted-foreground">Shipping</span>
                    {shipping === 0 ? (
                      <span className="text-green-600">Free</span>
                    ) : (
                      <span className="text-foreground">₹ {shipping.toFixed(2)}</span>
                    )}
                  </div>
                  <div className="flex justify-between text-sm">
                    <span className="text-muted-foreground">Tax</span>
                    <span className="text-foreground">₹ {tax.toFixed(2)}</span>
                  </div>
                  <div className="flex justify-between border-t border-border/40 pt-3 text-lg font-semibold">
                    <span className="text-foreground">Total</span>
                    <span className="text-foreground">₹ {total.toFixed(2)}</span>
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

    </div>
  )
}
