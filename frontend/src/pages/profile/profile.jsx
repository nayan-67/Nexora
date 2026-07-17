import { useContext, useEffect, useState } from "react"
import { Link, useLocation, useNavigate } from "react-router-dom"
import { Mail, Phone, MapPin, Calendar, Package, Heart, Settings, CreditCard, LogOut, Shield, Edit } from "lucide-react"
import { Button } from "@/components/ui/button"
import api from "@/lib/api"
import { toast } from "react-hot-toast"
import { AuthContext } from "@/context/AuthContext"
import { CartContext } from "@/context/CartContext"
import { StatCard, MenuItem } from "./ProfileComponents";
import profile_avatar from "@/assets/avatar.png"
const apiBase = api.defaults.baseURL.replace(/\/api\/?$/, "")

const menuItems = [
  {
    icon: Package,
    label: "Order History",
    description: "View and track your orders",
    to: "/orders",
  },
  {
    icon: Heart,
    label: "Wishlist",
    description: "Items you've saved for later",
    to: "/wishlist",
  },
  {
    icon: CreditCard,
    label: "Payment Methods",
    description: "Manage your saved cards",
    to: "/profile/payment",
  },
  {
    icon: MapPin,
    label: "Addresses",
    description: "Manage delivery addresses",
    to: "/profile/addresses",
  },
  {
    icon: Shield,
    label: "Security",
    description: "Password and security settings",
    to: "/profile/security",
  },
  {
    icon: Settings,
    label: "Preferences",
    description: "Notifications and preferences",
    to: "/profile/preferences",
  },
]

export default function ProfilePage() {
  const navigate = useNavigate()
  const location = useLocation()
  const from = location.state?.from || "/"
  // const [loading, setLoading] = useState(true)
  const { userData, setUserData } = useContext(AuthContext)
  const { setCartData } = useContext(CartContext)

  const logOut = () => {
    localStorage.removeItem("authToken")
    setUserData(null)
    setCartData([])
    navigate(from, { state: { logout: true }, replace: true })
  }
  // useEffect(() => {
  //   let active = true

  //   api.get("/profile")
  //     .then((response) => {
  //       if (active) {
  //         setProfile(response.data)
  //       }
  //     })
  //     .catch((error) => {
  //       toast.error(error.response?.data?.message || "Failed to load profile data.")
  //     })
  //     .finally(() => {
  //       if (active) {
  //         setLoading(false)
  //       }
  //     })

  //   return () => {
  //     active = false
  //   }
  // }, [])

  const user = userData?.user || {}
  const address = userData?.defaultaddress || {}
  const stats = userData?.stats || { orders: 0, wishlist: 0, rewards: 0 }
  const fullName = [user.first_name, user.last_name].filter(Boolean).join(" ") || null
  const memberSince = user.created_at
    ? new Date(user.created_at).toLocaleString("en-US", { month: "long", year: "numeric" })
    : null
  const avatar = user.profile_image
    ? `${apiBase}/uploads/${user.profile_image}`
    : profile_avatar
  const addressLine = [address.city, address.state].filter(Boolean).join(", ")
  return (
    <div className="flex min-h-screen flex-col bg-background pt-18.75">
      <main className="flex-1">
        <div className="mx-auto max-w-4xl px-4 py-8 sm:px-6 lg:px-8">
          <div className="overflow-hidden rounded-2xl border border-border/60 bg-card">
            <div className="relative h-32 bg-linear-to-r from-primary/20 via-primary/10 to-accent/20">
              <div className="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiMwMDAiIGZpbGwtb3BhY2l0eT0iMC4wMiI+PGNpcmNsZSBjeD0iMzAiIGN5PSIzMCIgcj0iMiIvPjwvZz48L2c+PC9zdmc+')] opacity-50" />
            </div>

            <div className="relative px-6 pb-6">
              <div className="-mt-16 flex flex-col items-center sm:flex-row sm:items-end sm:gap-6">
                <div className="relative">
                  <img
                    src={avatar}
                    alt={fullName}
                    className="h-32 w-32 rounded-2xl border-4 border-card object-cover shadow-lg"
                  />
                  {/* <div className="absolute -bottom-1 -right-1 h-6 w-6 rounded-full border-2 border-card bg-green-500" /> */}
                </div>
                <div className="mt-4 text-center sm:mt-0 sm:flex-1 sm:text-left">
                  <h1 className="text-2xl font-bold text-foreground" style={{ fontFamily: 'var(--font-heading)' }}>
                    {fullName ? fullName : (
                      <div className="h-7 bg-gray-300 rounded animate-pulse w-2/3"></div>
                    )}
                  </h1>
                  <div className="mt-1 text-muted-foreground">
                    {memberSince ? (
                      <>Member since {memberSince}</>
                    ) : (
                      <div className="h-6 bg-gray-300 rounded animate-pulse w-1/2"></div>
                    )}
                  </div>
                </div>
                <Button asChild className="mt-4 sm:mt-0">
                  <Link to="/profile/edit">
                    <Edit />
                    Edit Profile</Link>
                </Button>
              </div>

              <div className="mt-6 flex flex-wrap gap-4 border-t border-border/40 pt-6">
                <div className="flex items-center gap-2 text-sm text-muted-foreground">
                  <Mail className="h-4 w-4" />
                  {user.email || "No email"}
                </div>
                <div className="flex items-center gap-2 text-sm text-muted-foreground">
                  <Phone className="h-4 w-4" />
                  {user.phone || "No phone"}
                </div>
                <div className="flex items-center gap-2 text-sm text-muted-foreground">
                  <MapPin className="h-4 w-4" />
                  {addressLine || "No address"}
                </div>
              </div>
            </div>
          </div>

          <div className="mt-6 grid gap-4 sm:grid-cols-3">
            <StatCard icon={Package} label="Total Orders" value={stats.orders} />
            <StatCard icon={Heart} label="Wishlist Items" value={stats.wishlist} />
            <StatCard icon={Calendar} label="Reward Points" value={(stats.rewards || 0).toLocaleString()} />
          </div>

          <div className="mt-6 rounded-2xl border border-border/60 bg-card p-6">
            <div className="flex items-center justify-between">
              <h2 className="font-semibold text-foreground" style={{ fontFamily: 'var(--font-heading)' }}>
                Default Address
              </h2>
              <Link to="/profile/addresses" className="text-sm text-primary hover:underline">
                Manage
              </Link>
            </div>
            <div className="mt-4 flex items-start gap-3">
              <div className="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-muted">
                <MapPin className="h-5 w-5 text-muted-foreground" />
              </div>
              <div className="text-sm text-muted-foreground">
                <p className="font-medium text-foreground">{address.f_name} {address.l_name}</p>
                <p>{address.address1 || "No street address"}</p>
                {address.address2 ? <p>{address.address2}</p> : null}
                <p>
                  {[address.city, address.state, address.postcode].filter(Boolean).join(", ")}
                </p>
                <p>India</p>
                <p className="mt-1">{address.phone}</p>
              </div>
            </div>
          </div>

          <div className="mt-6 space-y-3">
            {menuItems.map((item) => (
              <MenuItem
                key={item.label}
                item={item}
                badge={item.label === "Wishlist" ? stats.wishlist : undefined}
              />
            ))}
          </div>

          <div className="mt-6">
            <Button
              variant="outline"
              onClick={logOut}
              className="mb-6 w-50 float-end cursor-pointer gap-2 py-5 text-destructive hover:bg-destructive hover:text-white"
            >
              <LogOut className="h-4 w-4" />
              Sign Out
            </Button>
          </div>
        </div>
      </main>
    </div>
  )
}
