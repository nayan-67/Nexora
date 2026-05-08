import { Link, useLocation, useNavigate } from "react-router-dom"
import { User, Mail, Phone, MapPin, Calendar, Package, Heart, Settings, CreditCard, LogOut, ChevronRight, Shield } from "lucide-react"
import { Button } from "@/components/ui/button"

const user = {
  name: "Sarah Anderson",
  email: "sarah.anderson@example.com",
  phone: "+1 (555) 123-4567",
  avatar: "https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=200&h=200&fit=crop&q=80",
  memberSince: "January 2024",
  address: {
    street: "123 Innovation Boulevard",
    city: "San Francisco",
    state: "CA",
    zip: "94102",
    country: "United States",
  },
  stats: {
    orders: 12,
    wishlist: 8,
    rewards: 2450,
  },
}

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
    badge: user.stats.wishlist,
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

function StatCard({ label, value, icon: Icon }) {
  return (
    <div className="flex flex-col items-center rounded-xl border border-border/60 bg-card p-4 text-center">
      <div className="flex h-10 w-10 items-center justify-center rounded-full bg-primary/10">
        <Icon className="h-5 w-5 text-primary" />
      </div>
      <p className="mt-3 text-2xl font-bold text-foreground" style={{ fontFamily: 'var(--font-heading)' }}>
        {value}
      </p>
      <p className="text-sm text-muted-foreground">{label}</p>
    </div>
  )
}

function MenuItem({ item }) {
  return (
    <Link
      to={item.to}
      className="flex items-center justify-between rounded-xl border border-border/60 bg-card p-4 transition-all hover:border-primary/30 hover:shadow-sm"
    >
      <div className="flex items-center gap-4">
        <div className="flex h-10 w-10 items-center justify-center rounded-full bg-muted">
          <item.icon className="h-5 w-5 text-muted-foreground" />
        </div>
        <div>
          <p className="font-medium text-foreground">{item.label}</p>
          <p className="text-sm text-muted-foreground">{item.description}</p>
        </div>
      </div>
      <div className="flex items-center gap-2">
        {item.badge && (
          <span className="flex h-6 w-6 items-center justify-center rounded-full bg-primary text-xs font-medium text-primary-foreground">
            {item.badge}
          </span>
        )}
        <ChevronRight className="h-5 w-5 text-muted-foreground" />
      </div>
    </Link>
  )
}

export default function ProfilePage() {
  const navigate = useNavigate();
  const location = useLocation();
  const from = location.state?.from || "/";
  const logOut = () => {
    localStorage.removeItem("authToken");
    navigate(from, { state: { logout: true }, replace: true });
    console.log("User logged out")
  }
  return (
    <div className="flex min-h-screen flex-col bg-background pt-18.75">
      {/* <Header /> */}

      <main className="flex-1">
        <div className="mx-auto max-w-4xl px-4 py-8 sm:px-6 lg:px-8">
          {/* Profile Header */}
          <div className="overflow-hidden rounded-2xl border border-border/60 bg-card">
            {/* Cover */}
            <div className="relative h-32 bg-linear-to-r from-primary/20 via-primary/10 to-accent/20">
              <div className="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiMwMDAiIGZpbGwtb3BhY2l0eT0iMC4wMiI+PGNpcmNsZSBjeD0iMzAiIGN5PSIzMCIgcj0iMiIvPjwvZz48L2c+PC9zdmc+')] opacity-50" />
            </div>

            {/* Avatar & Info */}
            <div className="relative px-6 pb-6">
              <div className="-mt-16 flex flex-col items-center sm:flex-row sm:items-end sm:gap-6">
                <div className="relative">
                  <img
                    src={user.avatar}
                    alt={user.name}
                    className="h-32 w-32 rounded-2xl border-4 border-card object-cover shadow-lg"
                  />
                  <div className="absolute -bottom-1 -right-1 h-6 w-6 rounded-full border-2 border-card bg-green-500" />
                </div>
                <div className="mt-4 text-center sm:mt-0 sm:flex-1 sm:text-left">
                  <h1 className="text-2xl font-bold text-foreground" style={{ fontFamily: 'var(--font-heading)' }}>
                    {user.name}
                  </h1>
                  <p className="mt-1 text-muted-foreground">
                    Member since {user.memberSince}
                  </p>
                </div>
                <Button asChild className="mt-4 sm:mt-0">
                  <Link to="/profile/edit">Edit Profile</Link>
                </Button>
              </div>

              {/* Contact Info */}
              <div className="mt-6 flex flex-wrap gap-4 border-t border-border/40 pt-6">
                <div className="flex items-center gap-2 text-sm text-muted-foreground">
                  <Mail className="h-4 w-4" />
                  {user.email}
                </div>
                <div className="flex items-center gap-2 text-sm text-muted-foreground">
                  <Phone className="h-4 w-4" />
                  {user.phone}
                </div>
                <div className="flex items-center gap-2 text-sm text-muted-foreground">
                  <MapPin className="h-4 w-4" />
                  {user.address.city}, {user.address.state}
                </div>
              </div>
            </div>
          </div>

          {/* Stats */}
          <div className="mt-6 grid gap-4 sm:grid-cols-3">
            <StatCard icon={Package} label="Total Orders" value={user.stats.orders} />
            <StatCard icon={Heart} label="Wishlist Items" value={user.stats.wishlist} />
            <StatCard icon={Calendar} label="Reward Points" value={user.stats.rewards.toLocaleString()} />
          </div>

          {/* Address */}
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
                <p className="font-medium text-foreground">{user.name}</p>
                <p>{user.address.street}</p>
                <p>{user.address.city}, {user.address.state} {user.address.zip}</p>
                <p>{user.address.country}</p>
              </div>
            </div>
          </div>

          {/* Menu Items */}
          <div className="mt-6 space-y-3">
            {menuItems.map((item) => (
              <MenuItem key={item.label} item={item} />
            ))}
          </div>

          {/* Logout */}
          <div className="mt-6">
            <Button variant="outline" onClick={logOut} className="w-50 float-end py-5 gap-2 text-destructive hover:bg-destructive hover:text-white mb-6 cursor-pointer">
              <LogOut className="h-4 w-4" />
              Sign Out
            </Button>
          </div>
        </div>
      </main>

      {/* <Footer /> */}
    </div>
  )
}
