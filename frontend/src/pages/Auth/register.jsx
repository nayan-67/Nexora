import { useState } from "react";
import { Eye, EyeOff, Mail, Lock, User, Phone, ShoppingBag, ArrowRight, Check, LoaderCircle } from "lucide-react";
import { Button } from "@/components/ui/button"
import { Link, useNavigate } from "react-router-dom";
import { GridBackground, DotBackground } from "@/components/lightswind/grid-dot-backgrounds";
import { BorderBeam } from "@/components/lightswind/border-beam";
import { CountUp } from "@/components/lightswind/count-up"
import ParticleOrbitEffect from "@/components/lightswind/particle-orbit-effect"
import axios from "axios";
import { toast } from "react-hot-toast";
import api from "@/lib/api"


const PasswordStrength = ({ password }) => {
  const checks = [
    { label: "8+ characters", pass: password.length >= 8 },
    { label: "Uppercase", pass: /[A-Z]/.test(password) },
    { label: "Number", pass: /\d/.test(password) },
    { label: "Special char", pass: /[^A-Za-z0-9]/.test(password) },
  ];
  const score = checks.filter((c) => c.pass).length;
  const colors = ["", "oklch(0.577 0.245 27.325)", "oklch(0.7 0.18 60)", "oklch(0.65 0.2 145)", "oklch(0.55 0.18 160)"];
  const labels = ["", "Weak", "Fair", "Good", "Strong"];

  if (!password) return null;

  return (
    <div className="mt-2 space-y-2">
      <div className="flex gap-1">
        {[1, 2, 3, 4].map((i) => (
          <div
            key={i}
            className="h-1 flex-1 rounded-full transition-all duration-300"
            style={{
              background: i <= score ? colors[score] : "oklch(0.9 0.01 280)",
            }}
          />
        ))}
      </div>
      <div className="flex items-center justify-between">
        <div className="flex gap-2 flex-wrap">
          {checks.map((c) => (
            <span
              key={c.label}
              className="flex items-center gap-1 text-xs"
              style={{ color: c.pass ? "oklch(0.45 0.15 155)" : "oklch(0.6 0.03 280)" }}
            >
              <Check size={10} />
              {c.label}
            </span>
          ))}
        </div>
        {score > 0 && (
          <span className="text-xs font-medium" style={{ color: colors[score] }}>
            {labels[score]}
          </span>
        )}
      </div>
    </div>
  );
};

export default function RegisterPage() {
  const [showPassword, setShowPassword] = useState(false);
  const [showConfirm, setShowConfirm] = useState(false);
  const [form, setForm] = useState({
    firstName: "",
    lastName: "",
    email: "",
    phone: "",
    password: "",
    confirmPassword: "",
    agreeTerms: false,
    newsletter: false,
  });
  const [isLoading, setIsLoading] = useState(false);

  const update = (field) => (e) => {
    const val = e.target.type === "checkbox" ? e.target.checked : e.target.value;
    setForm((prev) => ({ ...prev, [field]: val }));
  };
  const navigate = useNavigate();
  const handleSubmit = (e) => {
    e.preventDefault();
    setIsLoading(true);
    api.post(`/register`, form)
      .then((res) => {
        console.log("Registration successful:", res.data);
        // Redirect or show success message
        toast.success("Registration successful!");
        form.firstName = "";
        form.lastName = "";
        form.email = "";
        form.phone = "";
        form.password = "";
        form.confirmPassword = "";
        form.agreeTerms = false;
        form.newsletter = false;
        setTimeout(() => {
          navigate("/login");
        }, 5000);
      })
      .catch((err) => {
        console.error("Registration error:", err.response?.data?.message || err.message);
        if (err.response.status === 422) {
          const errors = Object.values(err.response.data.errors);
          errors.forEach((error) => {
            toast.error(error);
          });
        } else {
          toast.error("Registration failed. Please try again.");
        }
      })
      .finally(() => setIsLoading(false));
  };

  const inputStyle = {
    border: "1px solid oklch(0.88 0.01 280)",
    background: "oklch(0.97 0.005 280)",
    color: "oklch(0.13 0.02 280)",
  };
  const focusOn = (e) => (e.target.style.borderColor = "oklch(0.55 0.25 280)");
  const focusOff = (e) => (e.target.style.borderColor = "oklch(0.88 0.01 280)");

  return (
    <>
      <DotBackground dotSize={1}
        dotColor="#d4d4d4"
        darkDotColor="#404040"
        spacing={20}
        showFade={true}
        fadeIntensity={20}
        className="h-auto">
        <ParticleOrbitEffect
          particleCount={5}
          radius={20}
          intensity={1.2}
          colorRange={[180, 270]}
          autoColors={true}
        />
        <div
          className="min-h-screen flex md:px-10 lg:px-20">
          {/* Left panel */}
          <div
            className="hidden h-fit lg:flex lg:w-5/12 relative flex-col gap-15 p-12 mt-32 bg-background/80">
            {/* Orbs */}
            <div
              className="absolute bottom-[20%] left-0 w-70 h-70 rounded-full opacity-15"
              style={{ background: "oklch(0.65 0.2 250)", filter: "blur(80px)" }}
            />

            {/* Logo */}

            {/* Perks */}
            <div className="relative space-y-5">
              <h2 className="text-balance text-2xl font-bold tracking-tight text-foreground sm:text-3xl lg:text-5xl" style={{ fontFamily: 'var(--font-heading)' }}>
                Join the
                <br />
                <span className="bg-linear-to-r from-primary to-primary/60 bg-clip-text text-transparent">
                  Nexora
                </span>
                <br />
                Community
              </h2>
              <p className="text-sm leading-relaxed" style={{ color: "oklch(0.6 0.04 280)" }}>
                Create your account and unlock exclusive access to premium collections, member-only deals, and early access to new arrivals.
              </p>

              <div className="space-y-3 pt-2">
                {[
                  { icon: "🚚", title: "Free Shipping", desc: "On all orders over $50" },
                  { icon: "🎁", title: "Exclusive Offers", desc: "15% off your first order" },
                  { icon: "↩️", title: "Easy Returns", desc: "30-day hassle-free returns" },
                  { icon: "🔒", title: "Secure Checkout", desc: "100% secure payment processing" },
                ].map((perk) => (
                  <div key={perk.title} className="flex items-center gap-3">
                    <div
                      className="w-9 h-9 rounded-xl flex items-center justify-center text-base shrink-0 bg-primary/10 border border-primary/20">
                      {perk.icon}
                    </div>
                    <div>
                      <p className="text-sm font-medium bg-linear-to-r from-primary to-primary/60 bg-clip-text text-transparent">
                        {perk.title}
                      </p>
                      <p className="text-xs" style={{ color: "oklch(0.5 0.03 280)" }}>
                        {perk.desc}
                      </p>
                    </div>
                  </div>
                ))}
              </div>
            </div>

            {/* Social proof */}
            <div
              className="relative z-10 flex items-center gap-3 p-4 rounded-2xl bg-primary/10 border border-primary/20">
              <div className="flex -space-x-2">
                {["SJ", "MC", "ER", "JL"].map((init, i) => (
                  <div
                    key={i}
                    className="w-8 h-8 rounded-full border-2 flex items-center justify-center text-xs font-semibold text-white"
                    style={{
                      background: `oklch(${0.45 + i * 0.05} 0.2 ${280 + i * 20})`
                    }}
                  >
                    {init}
                  </div>
                ))}
              </div>
              <div>
                <span className="text-xs font-medium text-pretty text-muted-foreground">
                  <CountUp
                    value={50000}
                    suffix="+"
                    duration={3}
                    className="text-xs font-medium text-pretty text-muted-foreground"
                  /> happy customers
                </span>
                <div className="flex gap-0.5">
                  {[...Array(5)].map((_, i) => (
                    <span key={i} style={{ color: "oklch(0.75 0.18 80)", fontSize: "11px" }}>★</span>
                  ))}
                  <span className="text-xs ml-1" style={{ color: "oklch(0.55 0.03 280)" }}>
                    <CountUp
                      value={4.9}
                      decimals={1}
                      duration={3}
                      className="text-xs "
                    />/5</span>
                </div>
              </div>
            </div>
          </div>

          {/* Right panel — form */}
          <div
            className="flex-1 flex flex-col justify-center px-6 sm:px-10 lg:px-14 py-10 overflow-y-auto pt-32"
          // style={{ background: "oklch(0.99 0.002 280)" }}
          >
            <div
              className="absolute -top-15 right-0 w-87.5 h-87.5 rounded-full opacity-25"
              style={{ background: "oklch(0.55 0.25 280)", filter: "blur(90px)" }}
            />

            {/* Mobile logo */}

            <div className="w-full max-w-lg mx-auto bg-background/80 rounded-2xl p-8 relative">
              <BorderBeam
                colorFrom="#7400ff"
                colorTo="#9b41ff"
                size={70}
                duration={5}
                borderThickness={2}
                glowIntensity={3}
              />
              {/* Heading */}
              <div className="mb-7">
                <h2
                  className="text-3xl font-bold mb-1.5"
                  style={{
                    color: "oklch(0.13 0.02 280)",
                    fontFamily: "'Sora', ui-sans-serif, system-ui, sans-serif",
                  }}
                >
                  Create account
                </h2>
                <p className="text-sm" style={{ color: "oklch(0.5 0.03 280)" }}>
                  Join Nexora today — it's free and takes less than a minute
                </p>
              </div>

              {/* Social signup */}
              <div className="grid grid-cols-2 gap-3 mb-6">
                {[
                  {
                    name: "Google",
                    icon: (
                      <svg width="16" height="16" viewBox="0 0 24 24">
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
                      <svg width="16" height="16" viewBox="0 0 24 24" fill="#1877F2">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                      </svg>
                    ),
                  },
                ].map((s) => (
                  <button
                    key={s.name}
                    className="flex items-center justify-center gap-2 py-2.5 px-4 rounded-xl text-sm font-medium transition-all duration-200 hover:bg-gray-50 active:scale-[0.98]"
                    style={{
                      border: "1px solid oklch(0.88 0.01 280)",
                      color: "oklch(0.25 0.05 280)",
                      background: "white",
                    }}
                  >
                    {s.icon}
                    {s.name}
                  </button>
                ))}
              </div>

              {/* Divider */}
              <div className="relative mb-5">
                <div className="absolute inset-0 flex items-center">
                  <div className="w-full" style={{ borderTop: "1px solid oklch(0.9 0.01 280)" }} />
                </div>
                <div className="relative flex justify-center">
                  <span
                    className="px-4 text-xs"
                    style={{ background: "oklch(0.99 0.002 280)", color: "oklch(0.55 0.03 280)" }}
                  >
                    or register with email
                  </span>
                </div>
              </div>

              {/* Form */}
              <form onSubmit={handleSubmit} className="space-y-4">
                {/* Name row */}
                <div className="grid grid-cols-2 gap-3">
                  {[
                    { field: "firstName", label: "First Name", placeholder: "Sarah" },
                    { field: "lastName", label: "Last Name", placeholder: "Johnson" },
                  ].map(({ field, label, placeholder }) => (
                    <div key={field}>
                      <label className="block text-sm font-medium mb-1.5" style={{ color: "oklch(0.25 0.05 280)" }}>
                        {label} <span className="text-red-600">*</span>
                      </label>
                      <div className="relative">
                        <User
                          size={14}
                          className="absolute left-3 top-1/2 -translate-y-1/2"
                          style={{ color: "oklch(0.6 0.03 280)" }}
                        />
                        <input
                          type="text"
                          value={form[field]}
                          onChange={update(field)}
                          placeholder={placeholder}
                          name={field}
                          className="w-full pl-9 pr-3 py-2.5 rounded-xl text-sm outline-none transition-all duration-200"
                          style={inputStyle}
                          onFocus={focusOn}
                          onBlur={focusOff}
                          required
                        />
                      </div>
                    </div>
                  ))}
                </div>

                {/* Email */}
                <div>
                  <label className="block text-sm font-medium mb-1.5" style={{ color: "oklch(0.25 0.05 280)" }}>
                    Email Address <span className="text-red-600">*</span>
                  </label>
                  <div className="relative">
                    <Mail size={15} className="absolute left-3.5 top-1/2 -translate-y-1/2" style={{ color: "oklch(0.6 0.03 280)" }} />
                    <input
                      type="email"
                      value={form.email}
                      onChange={update("email")}
                      placeholder="you@example.com"
                      name="email"
                      className="w-full pl-10 pr-4 py-2.5 rounded-xl text-sm outline-none transition-all duration-200"
                      style={inputStyle}
                      onFocus={focusOn}
                      onBlur={focusOff}
                      required
                    />
                  </div>
                </div>

                {/* Phone */}
                <div>
                  <label className="block text-sm font-medium mb-1.5" style={{ color: "oklch(0.25 0.05 280)" }}>
                    Phone Number{" "}
                    <span className="text-xs font-normal" style={{ color: "oklch(0.6 0.03 280)" }}>(optional)</span>
                  </label>
                  <div className="relative">
                    <Phone size={15} className="absolute left-3.5 top-1/2 -translate-y-1/2" style={{ color: "oklch(0.6 0.03 280)" }} />
                    <input
                      type="tel"
                      value={form.phone}
                      onChange={update("phone")}
                      placeholder="+1 (555) 000-0000"
                      name="phone"
                      className="w-full pl-10 pr-4 py-2.5 rounded-xl text-sm outline-none transition-all duration-200"
                      style={inputStyle}
                      onFocus={focusOn}
                      onBlur={focusOff}
                    />
                  </div>
                </div>

                {/* Password */}
                <div>
                  <label className="block text-sm font-medium mb-1.5" style={{ color: "oklch(0.25 0.05 280)" }}>
                    Password <span className="text-red-600">*</span>
                  </label>
                  <div className="relative">
                    <Lock size={15} className="absolute left-3.5 top-1/2 -translate-y-1/2" style={{ color: "oklch(0.6 0.03 280)" }} />
                    <input
                      type={showPassword ? "text" : "password"}
                      value={form.password}
                      onChange={update("password")}
                      placeholder="Create a strong password"
                      name="password"
                      className="w-full pl-10 pr-10 py-2.5 rounded-xl text-sm outline-none transition-all duration-200"
                      style={inputStyle}
                      onFocus={focusOn}
                      onBlur={focusOff}
                      required
                    />
                    <div
                      onClick={() => setShowPassword(!showPassword)}
                      className="absolute right-3.5 top-1/2 -translate-y-1/2"
                      style={{ color: "oklch(0.6 0.03 280)" }}
                    >
                      {showPassword ? <EyeOff size={15} /> : <Eye size={15} />}
                    </div>
                  </div>
                  <PasswordStrength password={form.password} />
                </div>

                {/* Confirm Password */}
                <div>
                  <label className="block text-sm font-medium mb-1.5" style={{ color: "oklch(0.25 0.05 280)" }}>
                    Confirm Password <span className="text-red-600">*</span>
                  </label>
                  <div className="relative">
                    <Lock size={15} className="absolute left-3.5 top-1/2 -translate-y-1/2" style={{ color: "oklch(0.6 0.03 280)" }} />
                    <input
                      type={showConfirm ? "text" : "password"}
                      value={form.confirmPassword}
                      onChange={update("confirmPassword")}
                      placeholder="Repeat your password"
                      name="confirmPassword"
                      className="w-full pl-10 pr-10 py-2.5 rounded-xl text-sm outline-none transition-all duration-200"
                      style={{
                        ...inputStyle,
                        borderColor:
                          form.confirmPassword && form.confirmPassword !== form.password
                            ? "oklch(0.577 0.245 27.325)"
                            : form.confirmPassword && form.confirmPassword === form.password
                              ? "oklch(0.55 0.18 160)"
                              : "oklch(0.88 0.01 280)",
                      }}
                      onFocus={focusOn}
                      onBlur={focusOff}
                      required
                    />
                    <div
                      onClick={() => setShowConfirm(!showConfirm)}
                      className="absolute right-3.5 top-1/2 -translate-y-1/2"
                      style={{ color: "oklch(0.6 0.03 280)" }}
                    >
                      {showConfirm ? <EyeOff size={15} /> : <Eye size={15} />}
                    </div>
                  </div>
                  {form.confirmPassword && form.confirmPassword !== form.password && (
                    <p className="text-xs mt-1" style={{ color: "oklch(0.577 0.245 27.325)" }}>
                      Passwords do not match
                    </p>
                  )}
                  {form.confirmPassword && form.confirmPassword === form.password && (
                    <p className="text-xs mt-1 flex items-center gap-1" style={{ color: "oklch(0.45 0.15 155)" }}>
                      <Check size={11} /> Passwords match
                    </p>
                  )}
                </div>

                {/* Checkboxes */}
                <div className="space-y-2.5 pt-1">
                  <label className="flex items-start gap-2.5 cursor-pointer">
                    <input
                      type="checkbox"
                      checked={form.agreeTerms}
                      onChange={update("agreeTerms")}
                      className="mt-0.5 w-4 h-4 rounded shrink-0"
                      style={{ accentColor: "oklch(0.55 0.25 280)" }}
                      required
                    />
                    <span className="text-sm leading-relaxed" style={{ color: "oklch(0.45 0.03 280)" }}>
                      I agree to the{" "}
                      <a href="#" className="font-medium" style={{ color: "oklch(0.55 0.25 280)" }}>Terms of Service</a>{" "}
                      and{" "}
                      <a href="#" className="font-medium" style={{ color: "oklch(0.55 0.25 280)" }}>Privacy Policy</a>
                    </span>
                  </label>
                  <label className="flex items-start gap-2.5 cursor-pointer">
                    <input
                      type="checkbox"
                      checked={form.newsletter}
                      onChange={update("newsletter")}
                      className="mt-0.5 w-4 h-4 rounded shrink-0"
                      style={{ accentColor: "oklch(0.55 0.25 280)" }}
                    />
                    <span className="text-sm" style={{ color: "oklch(0.45 0.03 280)" }}>
                      Send me exclusive offers, new arrivals & lifestyle tips
                    </span>
                  </label>
                </div>

                {/* Submit */}
                <Button type="submit" disabled={isLoading || !form.agreeTerms} size="lg" className="h-11 w-full gap-2 whitespace-nowrap cursor-pointer rounded-xl active:scale-[0.98]! transition-all duration-200">
                  {isLoading ? (
                    <span className="flex items-center gap-2">
                      <LoaderCircle className="animate-spin h-4 w-4" />
                      Creating account...
                    </span>
                  ) : (
                    <>
                      Create Account
                      <ArrowRight size={16} />
                    </>
                  )}
                </Button>

              </form>

              <p className="text-center text-sm mt-5" style={{ color: "oklch(0.5 0.03 280)" }}>
                Already have an account?{" "}
                <Link to="/login" className="font-semibold" style={{ color: "oklch(0.55 0.25 280)" }}>
                  Sign in
                </Link>
              </p>
            </div>
          </div>
        </div>
      </DotBackground>
    </>
  );
}