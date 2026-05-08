import { useState } from "react";
import { Eye, EyeOff, Mail, Lock, ShoppingBag, ArrowRight, LoaderCircle } from "lucide-react";
import { Button } from "@/components/ui/button"
import { Link, useLocation, useNavigate } from "react-router-dom";
import { GridBackground, DotBackground } from "@/components/lightswind/grid-dot-backgrounds";
import { BorderBeam } from "@/components/lightswind/border-beam";
import ParticleOrbitEffect from "@/components/lightswind/particle-orbit-effect"
import axios from "axios";
import { toast } from "react-hot-toast";


export default function LoginPage() {
  const [showPassword, setShowPassword] = useState(false);
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [rememberMe, setRememberMe] = useState(false);
  const [isLoading, setIsLoading] = useState(false);
  const navigate = useNavigate();
  const location = useLocation();
  const from = location.state?.from || "/";

  const handleSubmit = (e) => {
    e.preventDefault();
    setIsLoading(true);
    axios.post("http://192.168.0.121:8000/api/login", { email, password })
      .then(res => {
        const token = res.data.token;
        localStorage.setItem("authToken", token);
        navigate(from, { state: { loginSuccess: true } });
      })
      .catch(error => {
        console.error("Login error:", error.response?.data?.message || error.message);
        if (error.response?.status === 401) {
          toast.error("Invalid email or password!");
        } else {
          toast.error("Login failed!");
        }
      })
      .finally(() => setIsLoading(false));
  };

  return (
    <>
      <DotBackground dotSize={1}
        dotColor="#d4d4d4"
        darkDotColor="#404040"
        spacing={20}
        showFade={true}
        fadeIntensity={20}>
        <ParticleOrbitEffect
          particleCount={5}
          radius={20}
          intensity={1.2}
          colorRange={[180, 270]}
          autoColors={true}
        />
        <div
          className="flex min-h-screen md:px-10 lg:px-20 login-container">
          {/* Left Panel — Brand Side */}
          <div
            className="hidden md:flex lg:flex lg:w-1/2 relative flex-col justify-between p-12 overflow-hidden pt-30">
            {/* Decorative orb blobs */}

            {/* Logo */}

            {/* Center copy */}
            <div className="relative z-10 space-y-6 bg-background/80 py-6 ps-6">
              <span className="mb-6 inline-flex items-center rounded-full bg-primary/10 px-4 py-1.5 text-xs font-medium text-primary">
                New Collection 2026
              </span>
              <h1 className="text-balance text-4xl font-bold tracking-tight text-foreground sm:text-5xl lg:text-6xl" style={{ fontFamily: 'var(--font-heading)' }}>
                Upgrade Your{" "}
                <span className="bg-linear-to-r from-primary to-primary/60 bg-clip-text text-transparent">
                  Lifestyle
                </span>
              </h1>
              <p className="mt-6 max-w-lg text-pretty text-lg text-muted-foreground">
                Discover curated collections of premium products designed to elevate every aspect of your daily life.
              </p>

            </div>

          </div>

          {/* Right Panel — Form */}
          <div
            className="flex-1 flex flex-col md:flex-row justify-center px-6 sm:px-12 lg:px-16 py-12 pt-15">
            {/* Mobile logo */}

            <div className="relative w-full max-w-md mx-auto bg-background/80 rounded-xl p-4 sm:p-6 lg:p-8">
              <BorderBeam
                colorFrom="#7400ff"
                colorTo="#9b41ff"
                size={70}
                duration={5}
                borderThickness={2}
                glowIntensity={3}
              />
              {/* Heading */}
              <div className="mb-8">
                <h2
                  className="text-3xl font-bold mb-2"
                  style={{
                    color: "oklch(0.13 0.02 280)",
                    fontFamily: "'Sora', ui-sans-serif, system-ui, sans-serif",
                  }}
                >
                  Welcome back
                </h2>
                <p className="text-sm" style={{ color: "oklch(0.5 0.03 280)" }}>
                  Sign in to your Nexora account to continue shopping
                </p>
              </div>

              {/* Social login */}
              <div className="grid grid-cols-2 gap-3 mb-6">
                {[
                  {
                    name: "Google",
                    icon: (
                      <svg width="18" height="18" viewBox="0 0 24 24">
                        <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                        <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                        <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                        <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                      </svg>
                    ),
                  },
                  {
                    name: "Facebook",
                    icon: (
                      <svg width="18" height="18" viewBox="0 0 24 24" fill="#1877F2">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                      </svg>
                    ),
                  },
                ].map((social) => (
                  <button
                    key={social.name}
                    className="flex items-center justify-center gap-2.5 py-2.5 px-4 rounded-xl text-sm font-medium transition-all duration-200 hover:bg-gray-50 active:scale-[0.98]"
                    style={{
                      border: "1px solid oklch(0.88 0.01 280)",
                      color: "oklch(0.25 0.05 280)",
                      background: "white",
                    }}
                  >
                    {social.icon}
                    {social.name}
                  </button>
                ))}
              </div>

              {/* Divider */}
              <div className="relative mb-6">
                <div className="absolute inset-0 flex items-center">
                  <div className="w-full" style={{ borderTop: "1px solid oklch(0.9 0.01 280)" }} />
                </div>
                <div className="relative flex justify-center">
                  <span
                    className="px-4 text-xs"
                    style={{
                      background: "oklch(0.99 0.002 280)",
                      color: "oklch(0.55 0.03 280)",
                    }}
                  >
                    or continue with email
                  </span>
                </div>
              </div>

              {/* Form */}
              <form onSubmit={handleSubmit} className="space-y-4">
                {/* Email */}
                <div>
                  <label
                    className="block text-sm font-medium mb-1.5"
                    style={{ color: "oklch(0.25 0.05 280)" }}
                  >
                    Email Address
                  </label>
                  <div className="relative">
                    <Mail
                      size={16}
                      className="absolute left-3.5 top-1/2 -translate-y-1/2"
                      style={{ color: "oklch(0.6 0.03 280)" }}
                    />
                    <input
                      type="email"
                      value={email}
                      onChange={(e) => setEmail(e.target.value)}
                      placeholder="you@example.com"
                      className="w-full pl-10 pr-4 py-2.5 rounded-xl text-sm outline-none transition-all duration-200"
                      style={{
                        border: "1px solid oklch(0.88 0.01 280)",
                        background: "oklch(0.97 0.005 280)",
                        color: "oklch(0.13 0.02 280)",
                      }}
                      onFocus={(e) => (e.target.style.borderColor = "oklch(0.55 0.25 280)")}
                      onBlur={(e) => (e.target.style.borderColor = "oklch(0.88 0.01 280)")}
                      required
                    />
                  </div>
                </div>

                {/* Password */}
                <div>
                  <div className="flex items-center justify-between mb-1.5">
                    <label className="block text-sm font-medium" style={{ color: "oklch(0.25 0.05 280)" }}>
                      Password
                    </label>
                  </div>
                  <div className="relative">
                    <Lock
                      size={16}
                      className="absolute left-3.5 top-1/2 -translate-y-1/2"
                      style={{ color: "oklch(0.6 0.03 280)" }}
                    />
                    <input
                      type={showPassword ? "text" : "password"}
                      value={password}
                      onChange={(e) => setPassword(e.target.value)}
                      placeholder="Enter your password"
                      className="w-full pl-10 pr-10 py-2.5 rounded-xl text-sm outline-none transition-all duration-200"
                      style={{
                        border: "1px solid oklch(0.88 0.01 280)",
                        background: "oklch(0.97 0.005 280)",
                        color: "oklch(0.13 0.02 280)",
                      }}
                      onFocus={(e) => (e.target.style.borderColor = "oklch(0.55 0.25 280)")}
                      onBlur={(e) => (e.target.style.borderColor = "oklch(0.88 0.01 280)")}
                      required
                    />
                    <div
                      onClick={() => setShowPassword(!showPassword)}
                      className="absolute right-3.5 top-1/2 -translate-y-1/2"
                      style={{ color: "oklch(0.6 0.03 280)" }}
                    >
                      {showPassword ? <EyeOff size={16} /> : <Eye size={16} />}
                    </div>
                  </div>
                </div>

                {/* Remember me */}
                <div className="flex items-center justify-between mb-2">
                  <div className="flex items-center gap-2.5">
                    <input
                      type="checkbox"
                      id="remember"
                      checked={rememberMe}
                      onChange={(e) => setRememberMe(e.target.checked)}
                      className="w-4 h-4 rounded"
                      style={{ accentColor: "oklch(0.55 0.25 280)" }}
                    />
                    <label htmlFor="remember" className="text-sm" style={{ color: "oklch(0.45 0.03 280)" }}>
                      Remember me for 30 days
                    </label>
                  </div>
                  <a
                    href="#"
                    className="text-xs font-medium"
                    style={{ color: "oklch(0.55 0.25 280)" }}
                  >
                    Forgot password?
                  </a>
                </div>

                {/* Submit */}
                <Button type="submit" disabled={isLoading} size="lg" className="h-11 w-full gap-2 whitespace-nowrap cursor-pointer rounded-xl">
                  {isLoading ? (
                    <span className="flex items-center gap-2">
                      <LoaderCircle className="animate-spin h-4 w-4" />
                      Signing in...
                    </span>
                  ) : (
                    <>
                      Sign In
                      <ArrowRight className="h-4 w-4" />
                    </>
                  )}
                </Button>
              </form>

              {/* Footer */}
              <p className="text-center text-sm mt-6" style={{ color: "oklch(0.5 0.03 280)" }}>
                Don't have an account?{" "}
                <Link to="/register" className="font-semibold" style={{ color: "oklch(0.55 0.25 280)" }}>
                  Create account
                </Link>
              </p>
            </div>
          </div>
        </div>
      </DotBackground>
    </>
  );
}