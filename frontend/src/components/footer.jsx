import { Link } from "react-router-dom"
import Logo from "@/assets/logo.png"
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome"
import { faLinkedin, faSquareFacebook, faSquareInstagram, faSquareXTwitter } from "@fortawesome/free-brands-svg-icons"

const footerLinks = {
  shop: [
    { label: "New Arrivals", to: "/new-arrivals" },
    { label: "Bestsellers", to: "/bestsellers" },
    { label: "Sale", to: "/sale" },
    { label: "Gift Cards", to: "/gift-cards" },
  ],
  categories: [
    { label: "Fashion", to: "/categories/fashion" },
    { label: "Electronics", to: "/categories/electronics" },
    { label: "Accessories", to: "/categories/accessories" },
    { label: "Home", to: "/categories/home" },
  ],
  support: [
    { label: "Contact Us", to: "/contact" },
    { label: "FAQs", to: "/faqs" },
    { label: "Shipping Info", to: "/shipping" },
    { label: "Returns", to: "/returns" },
  ],
  company: [
    { label: "About Us", to: "/about" },
    { label: "Careers", to: "/careers" },
    { label: "Press", to: "/press" },
    { label: "Sustainability", to: "/sustainability" },
  ],
}

const socialLinks = [
  { icon: faSquareXTwitter, label: "Twitter", href: "https://twitter.com" },
  { icon: faSquareInstagram, label: "Instagram", href: "https://instagram.com" },
  { icon: faSquareFacebook, label: "Facebook", href: "https://facebook.com" },
  { icon: faLinkedin, label: "LinkedIn", href: "https://linkedin.com" },
]

export function Footer() {
  return (
    <footer className="border-t border-border/40 bg-card/50">
      <div className="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <div className="grid gap-8 lg:grid-cols-6">
          {/* Brand */}
          <div className="lg:col-span-2">
            <Link to="/" className="flex items-center gap-2">
              <img src={Logo} alt="Nexora Logo" className="h-25 w-auto" />
            </Link>
            <p className="mt-4 max-w-xs text-sm text-muted-foreground">
              Curating premium products to elevate your lifestyle. Quality, style, and innovation in every detail.
            </p>
            <div className="mt-6 flex gap-1">
              {socialLinks.map((link) => (
                <a
                  key={link.label}
                  href={link.href}
                  target="_blank"
                  rel="noopener noreferrer"
                  className="text-sm text-muted-foreground hover:text-foreground hover:scale-110 transition-all"
                >
                  <FontAwesomeIcon icon={link.icon} className="ml-1 text-3xl" />
                </a>
              ))}
            </div>
          </div>

          {/* Links */}
          <div>
            <h3 className="text-sm font-semibold text-foreground">Shop</h3>
            <ul className="mt-4 space-y-3">
              {footerLinks.shop.map((link) => (
                <li key={link.to}>
                  <Link to={link.to} className="text-sm text-muted-foreground hover:text-foreground hover:scale-110 transition-all">
                    {link.label}
                  </Link>
                </li>
              ))}
            </ul>
          </div>

          <div>
            <h3 className="text-sm font-semibold text-foreground">Categories</h3>
            <ul className="mt-4 space-y-3">
              {footerLinks.categories.map((link) => (
                <li key={link.to}>
                  <Link to={link.to} className="text-sm text-muted-foreground transition-colors hover:text-foreground">
                    {link.label}
                  </Link>
                </li>
              ))}
            </ul>
          </div>

          <div>
            <h3 className="text-sm font-semibold text-foreground">Support</h3>
            <ul className="mt-4 space-y-3">
              {footerLinks.support.map((link) => (
                <li key={link.to}>
                  <Link to={link.to} className="text-sm text-muted-foreground transition-colors hover:text-foreground">
                    {link.label}
                  </Link>
                </li>
              ))}
            </ul>
          </div>

          <div>
            <h3 className="text-sm font-semibold text-foreground">Company</h3>
            <ul className="mt-4 space-y-3">
              {footerLinks.company.map((link) => (
                <li key={link.to}>
                  <Link to={link.to} className="text-sm text-muted-foreground transition-colors hover:text-foreground">
                    {link.label}
                  </Link>
                </li>
              ))}
            </ul>
          </div>
        </div>

        {/* Bottom */}
        <div className="mt-10 flex flex-col items-center justify-between gap-4 border-t border-border/40 pt-8 sm:flex-row">
          <p className="text-sm text-muted-foreground">
            &copy; {new Date().getFullYear()} <Link to={"/"} className="text-sm font-medium text-muted-foreground transition-colors hover:text-foreground">
              Nexora
            </Link>. All rights reserved.
          </p>
          <div className="flex gap-6">
            <Link to="/privacy" className="text-sm text-muted-foreground transition-colors hover:text-foreground">
              Privacy Policy
            </Link>
            <Link to="/terms" className="text-sm text-muted-foreground transition-colors hover:text-foreground">
              Terms of Service
            </Link>
          </div>
        </div>
      </div>
    </footer>
  )
}
