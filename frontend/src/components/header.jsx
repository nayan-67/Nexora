import { useState } from "react"
import { Link, NavLink } from "react-router-dom"
import { Menu, X, ShoppingBag, Search, User, ChevronDown } from "lucide-react"
import { Button } from "@/components/ui/button"
import { cn } from "@/lib/utils"
import { categoryData } from "@/lib/products"
import logo from "@/assets/logo.png"
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome"
import { faRightToBracket } from "@fortawesome/free-solid-svg-icons/faRightToBracket"
import { Tooltip, TooltipTrigger, TooltipContent } from "@/components/ui/tooltip"
import api from "@/lib/api"

const navLinks = [
  { to: "/shop", label: "Shop" },
  { to: "/categories", label: "Categories", hasDropdown: true },
  { to: "/shop?filter=new", label: "New Arrivals" },
  { to: "/shop?filter=sale", label: "Sale" },
]

export function Header() {
  const [mobileMenuOpen, setMobileMenuOpen] = useState(false)
  const [categoryDropdownOpen, setCategoryDropdownOpen] = useState(false)
  const [isLogin, setisLogin] = useState(false)

  api.get("/user").then((response) => {
    if (response.status === 200) {
      setisLogin(true)
    } else {
      setisLogin(false)
    }
  }).catch(() => {
    setisLogin(false)
  })

  return (
    <header className="sticky top-5 z-50 w-[85%] mx-auto -mb-18.75 rounded-[40px] border border-border/40 bg-[#e7ebf2c9] backdrop-blur-xl shadow-xl">
      <div className="mx-auto flex h-18 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
        {/* Logo */}
        <Link to="/" className="flex items-center gap-2">
          <img src={logo} alt="Nexora Logo" className="w-25 h-auto drop-shadow-[0_0_5px_rgba(0,0,0,0.2)]" />
        </Link>

        {/* Desktop Navigation */}
        <nav className="hidden items-center gap-1 md:flex">
          {navLinks.map((link) => (
            <div
              key={link.to}
              className="relative"
              onMouseEnter={() => link.hasDropdown && setCategoryDropdownOpen(true)}
              onMouseLeave={() => link.hasDropdown && setCategoryDropdownOpen(false)}
            >
              <NavLink
                to={link.to}
                className="group relative flex items-center gap-1 px-4 py-2 text-sm font-medium text-muted-foreground transition-colors duration-300 hover:text-foreground"
              >
                <span className="relative z-10">{link.label}</span>
                {link.hasDropdown && (
                  <ChevronDown className={cn(
                    "h-3.5 w-3.5 transition-transform duration-300",
                    categoryDropdownOpen && "rotate-180"
                  )} />
                )}
                <span className="absolute inset-0 z-0 scale-75 rounded-full bg-accent opacity-0 transition-all duration-300 ease-out group-hover:scale-100 group-hover:opacity-100" />
                <span className="absolute bottom-1 left-1/2 h-0.5 w-0 -translate-x-1/2 rounded-full bg-primary transition-all duration-300 ease-out group-hover:w-6" />
              </NavLink>

              {/* Category Dropdown */}
              {link.hasDropdown && (
                <div className={cn(
                  "absolute left-1/2 top-full pt-2 -translate-x-1/2 transition-all duration-300",
                  categoryDropdownOpen
                    ? "pointer-events-auto visible opacity-100 translate-y-0"
                    : "pointer-events-none invisible opacity-0 translate-y-2"
                )}>
                  <div className="w-80 overflow-hidden rounded-2xl border border-border bg-card shadow-xl">
                    <div className="p-2">
                      {categoryData.map((category, index) => (
                        <Link
                          key={category.slug}
                          to={`/category/${category.slug}`}
                          className="group/item flex items-center gap-4 rounded-xl p-3 transition-colors hover:bg-accent"
                        >
                          <div className="h-14 w-14 overflow-hidden rounded-lg bg-muted">
                            <img
                              src={category.image}
                              alt={category.name}
                              className="h-full w-full object-cover transition-transform duration-300 group-hover/item:scale-110"
                            />
                          </div>
                          <div className="flex-1">
                            <h4 className="font-medium text-foreground transition-colors group-hover/item:text-primary">
                              {category.name}
                            </h4>
                            <p className="mt-0.5 text-xs text-muted-foreground line-clamp-1">
                              {category.description}
                            </p>
                          </div>
                        </Link>
                      ))}
                    </div>
                    <div className="border-t border-border bg-muted/30 p-3">
                      <Link
                        to="/categories"
                        className="flex items-center justify-center gap-2 rounded-lg bg-primary/10 px-4 py-2.5 text-sm font-medium text-primary transition-colors hover:bg-primary/20"
                      >
                        View All Categories
                      </Link>
                    </div>
                  </div>
                </div>
              )}
            </div>
          ))}
        </nav>

        {/* Desktop Actions */}
        <div className="hidden items-center gap-2 md:flex">
          {!isLogin && (
            <Tooltip>
              <TooltipTrigger asChild>
                <Button variant="ghost" size="icon" className="text-muted-foreground hover:text-foreground" asChild>
                  <Link to="/login">
                    <FontAwesomeIcon icon={faRightToBracket} className="h-5 w-5" />
                    <span className="sr-only">LogIn</span>
                  </Link>
                </Button>
              </TooltipTrigger>
              <TooltipContent>
                <p>Log In</p>
              </TooltipContent>
            </Tooltip>
          )}
          <Button variant="ghost" size="icon" className="text-muted-foreground hover:text-foreground">
            <Search className="h-5 w-5" />
            <span className="sr-only">Search</span>
          </Button>
          {isLogin && (
            <Button variant="ghost" size="icon" className="text-muted-foreground hover:text-foreground" asChild>
              <Link to="/profile">
                <User className="h-5 w-5" />
                <span className="sr-only">Account</span>
              </Link>
            </Button>
          )}
          <Button variant="ghost" size="icon" className="relative text-muted-foreground hover:text-foreground" asChild>
            <Link to="/cart">
              <ShoppingBag className="h-5 w-5" />
              <span className="absolute -right-0.5 -top-0.5 flex h-4 w-4 items-center justify-center rounded-full bg-primary text-[10px] font-medium text-primary-foreground">
                3
              </span>
              <span className="sr-only">Cart</span>
            </Link>
          </Button>
        </div>

        {/* Mobile Menu Button */}
        <div className="flex items-center gap-2 md:hidden">
          <Button variant="ghost" size="icon" className="relative text-muted-foreground hover:text-foreground" asChild>
            <Link to="/cart">
              <ShoppingBag className="h-5 w-5" />
              <span className="absolute -right-0.5 -top-0.5 flex h-4 w-4 items-center justify-center rounded-full bg-primary text-[10px] font-medium text-primary-foreground">
                3
              </span>
              <span className="sr-only">Cart</span>
            </Link>
          </Button>
          <Button
            variant="ghost"
            size="icon"
            onClick={() => setMobileMenuOpen(!mobileMenuOpen)}
            className="text-muted-foreground hover:text-foreground"
          >
            {mobileMenuOpen ? <X className="h-5 w-5" /> : <Menu className="h-5 w-5" />}
            <span className="sr-only">Menu</span>
          </Button>
        </div>
      </div>

      {/* Mobile Menu */}
      {mobileMenuOpen && (
        <div className="border-t border-border/40 bg-background md:hidden">
          <nav className="flex flex-col px-4 py-4">
            {navLinks.map((link) => (
              <div key={link.to}>
                <Link
                  to={link.to}
                  className="py-3 text-base font-medium text-muted-foreground transition-colors hover:text-foreground"
                  onClick={() => setMobileMenuOpen(false)}
                >
                  {link.label}
                </Link>
                {link.hasDropdown && (
                  <div className="ml-4 flex flex-col border-l border-border/60 pl-4">
                    {categoryData.map((category) => (
                      <Link
                        key={category.slug}
                        to={`/category/${category.slug}`}
                        className="py-2 text-sm text-muted-foreground transition-colors hover:text-foreground"
                        onClick={() => setMobileMenuOpen(false)}
                      >
                        {category.name}
                      </Link>
                    ))}
                  </div>
                )}
              </div>
            ))}
            <div className="mt-4 flex items-center gap-4 border-t border-border/40 pt-4">
              <Button variant="ghost" size="sm" className="gap-2 text-muted-foreground">
                <Search className="h-4 w-4" />
                Search
              </Button>
              {isLogin && (
                <Button variant="ghost" size="sm" className="gap-2 text-muted-foreground" asChild>
                  <Link to="/profile">
                    <User className="h-4 w-4" />
                    Account
                  </Link>
                </Button>
              )}
              {/* {!isLogin && (
              )} */}
              <Button variant="ghost" size="icon" className="text-muted-foreground hover:text-foreground" asChild>
                <Link to="/login">
                  <FontAwesomeIcon icon={faRightToBracket} className="h-5 w-5" />
                  <span className="sr-only">LogIn</span>
                </Link>
              </Button>

            </div>
          </nav>
        </div>
      )}
    </header>
  )
}
