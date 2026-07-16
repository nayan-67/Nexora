import { useState, useEffect, useRef } from "react"
import { Link } from "react-router-dom"
import { Home, ShoppingBag, ArrowLeft, Search } from "lucide-react"
import logo from "@/assets/nexora-logo.svg"

function FloatingParticle({ delay, duration, x, size, color }) {
    return (
        <div
            style={{
                position: "absolute",
                left: `${x}%`,
                bottom: "-20px",
                width: size,
                height: size,
                borderRadius: "50%",
                background: color,
                opacity: 0,
                animation: `floatUp ${duration}s ease-in ${delay}s infinite`,
            }}
        />
    )
}

function AstronautSVG() {
    return (
        <svg
            viewBox="0 0 200 280"
            width="200"
            height="280"
            style={{ animation: "float 4s ease-in-out infinite", filter: "drop-shadow(0 20px 40px oklch(0.55 0.25 280 / 0.3))" }}
        >
            {/* Helmet outer */}
            <ellipse cx="100" cy="90" rx="52" ry="55" fill="oklch(0.93 0.01 280)" stroke="oklch(0.75 0.05 280)" strokeWidth="2" />
            {/* Helmet visor */}
            <ellipse cx="100" cy="88" rx="34" ry="30" fill="oklch(0.55 0.25 280)" opacity="0.9" />
            {/* Visor shine */}
            <ellipse cx="88" cy="76" rx="10" ry="7" fill="white" opacity="0.25" />
            <ellipse cx="95" cy="72" rx="4" ry="3" fill="white" opacity="0.4" />
            {/* Neck */}
            <rect x="85" y="140" width="30" height="16" rx="4" fill="oklch(0.88 0.02 280)" stroke="oklch(0.75 0.05 280)" strokeWidth="1.5" />
            {/* Body suit */}
            <rect x="60" y="152" width="80" height="85" rx="20" fill="oklch(0.93 0.01 280)" stroke="oklch(0.75 0.05 280)" strokeWidth="2" />
            {/* Chest panel */}
            <rect x="78" y="165" width="44" height="35" rx="8" fill="oklch(0.85 0.05 280)" stroke="oklch(0.65 0.1 280)" strokeWidth="1" />
            {/* Chest panel buttons */}
            <circle cx="90" cy="175" r="4" fill="oklch(0.55 0.25 280)" />
            <circle cx="100" cy="175" r="4" fill="oklch(0.65 0.2 250)" />
            <circle cx="110" cy="175" r="4" fill="oklch(0.65 0.18 145)" />
            <rect x="84" y="185" width="32" height="4" rx="2" fill="oklch(0.7 0.08 280)" />
            <rect x="84" y="192" width="20" height="3" rx="1.5" fill="oklch(0.75 0.06 280)" />
            {/* Left arm */}
            <rect x="28" y="155" width="36" height="22" rx="11" fill="oklch(0.93 0.01 280)" stroke="oklch(0.75 0.05 280)" strokeWidth="2" transform="rotate(20 46 166)" />
            {/* Left glove */}
            <ellipse cx="24" cy="188" rx="14" ry="10" fill="oklch(0.75 0.05 280)" transform="rotate(20 24 188)" />
            {/* Right arm — waving */}
            <rect x="136" y="148" width="36" height="22" rx="11" fill="oklch(0.93 0.01 280)" stroke="oklch(0.75 0.05 280)" strokeWidth="2" transform="rotate(-35 154 159)" style={{ transformOrigin: "136px 159px", animation: "wave 2s ease-in-out infinite" }} />
            {/* Right glove */}
            <ellipse cx="174" cy="128" rx="14" ry="10" fill="oklch(0.75 0.05 280)" transform="rotate(-35 174 128)" style={{ animation: "wave 2s ease-in-out infinite", transformOrigin: "136px 159px" }} />
            {/* Legs */}
            <rect x="68" y="228" width="28" height="42" rx="12" fill="oklch(0.93 0.01 280)" stroke="oklch(0.75 0.05 280)" strokeWidth="2" />
            <rect x="104" y="228" width="28" height="42" rx="12" fill="oklch(0.93 0.01 280)" stroke="oklch(0.75 0.05 280)" strokeWidth="2" />
            {/* Boots */}
            <ellipse cx="82" cy="270" rx="18" ry="8" fill="oklch(0.75 0.05 280)" />
            <ellipse cx="118" cy="270" rx="18" ry="8" fill="oklch(0.75 0.05 280)" />
            {/* Helmet antenna */}
            <line x1="100" y1="35" x2="100" y2="15" stroke="oklch(0.75 0.05 280)" strokeWidth="3" strokeLinecap="round" />
            <circle cx="100" cy="12" r="5" fill="oklch(0.55 0.25 280)" style={{ animation: "blink 2s ease-in-out infinite" }} />
            {/* Stars reflected in visor */}
            <circle cx="87" cy="82" r="1.5" fill="white" opacity="0.6" />
            <circle cx="113" cy="78" r="1" fill="white" opacity="0.5" />
            <circle cx="105" cy="95" r="1.5" fill="white" opacity="0.4" />
        </svg>
    )
}

function StarField() {
    const stars = Array.from({ length: 60 }, (_, i) => ({
        id: i,
        x: Math.random() * 100,
        y: Math.random() * 100,
        r: Math.random() * 2 + 0.5,
        delay: Math.random() * 4,
        dur: Math.random() * 3 + 2,
    }))

    return (
        <svg
            style={{ position: "absolute", inset: 0, width: "100%", height: "100%", pointerEvents: "none" }}
            viewBox="0 0 800 600"
            preserveAspectRatio="xMidYMid slice"
        >
            {stars.map((s) => (
                <circle
                    key={s.id}
                    cx={s.x * 8}
                    cy={s.y * 6}
                    r={s.r}
                    fill="oklch(0.55 0.25 280)"
                    opacity="0"
                    style={{ animation: `twinkle ${s.dur}s ease-in-out ${s.delay}s infinite` }}
                />
            ))}
            {/* Orbit ring */}
            <ellipse cx="400" cy="300" rx="260" ry="80" fill="none" stroke="oklch(0.55 0.25 280)" strokeWidth="0.5" opacity="0.15" strokeDasharray="6 10" style={{ animation: "spinOrbit 20s linear infinite" }} />
            {/* Orbiting dot */}
            <circle r="5" fill="oklch(0.65 0.2 250)" opacity="0.7" style={{ offsetPath: "ellipse(260px 80px at 400px 300px)", animation: "orbitDot 8s linear infinite", offsetRotate: "0deg" }} />
        </svg>
    )
}

const particles = Array.from({ length: 18 }, (_, i) => ({
    id: i,
    delay: (i * 0.7) % 6,
    duration: 5 + (i % 4),
    x: 5 + (i * 5.5) % 90,
    size: `${4 + (i % 5)}px`,
    color: i % 3 === 0 ? "oklch(0.55 0.25 280)" : i % 3 === 1 ? "oklch(0.65 0.2 250)" : "oklch(0.65 0.18 145)",
}))

export default function NotFoundPage() {
    const [mousePos, setMousePos] = useState({ x: 0.5, y: 0.5 })
    const containerRef = useRef(null)

    useEffect(() => {
        const handleMouse = (e) => {
            if (!containerRef.current) return
            const rect = containerRef.current.getBoundingClientRect()
            setMousePos({
                x: (e.clientX - rect.left) / rect.width,
                y: (e.clientY - rect.top) / rect.height,
            })
        }
        const el = containerRef.current
        el?.addEventListener("mousemove", handleMouse)
        return () => el?.removeEventListener("mousemove", handleMouse)
    }, [])

    return (
        <div
            ref={containerRef}
            className="relative min-h-screen flex flex-col items-center justify-center overflow-hidden"
            style={{
                background: "oklch(0.07 0.025 280)",
                fontFamily: "'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif",
            }}
        >
            <style>{`
        @keyframes float {
          0%, 100% { transform: translateY(0px) rotate(-2deg); }
          50% { transform: translateY(-24px) rotate(2deg); }
        }
        @keyframes wave {
          0%, 100% { transform: rotate(-35deg); }
          50% { transform: rotate(-10deg); }
        }
        @keyframes blink {
          0%, 100% { opacity: 1; }
          50% { opacity: 0.2; }
        }
        @keyframes twinkle {
          0%, 100% { opacity: 0; transform: scale(0.8); }
          50% { opacity: 0.9; transform: scale(1.2); }
        }
        @keyframes floatUp {
          0% { opacity: 0; transform: translateY(0) scale(0.5); }
          20% { opacity: 0.7; }
          80% { opacity: 0.3; }
          100% { opacity: 0; transform: translateY(-500px) scale(1.2); }
        }
        @keyframes spinOrbit {
          from { transform: rotate(0deg); transform-origin: 400px 300px; }
          to { transform: rotate(360deg); transform-origin: 400px 300px; }
        }
        @keyframes orbitDot {
          from { offset-distance: 0%; }
          to { offset-distance: 100%; }
        }
        @keyframes glitch1 {
          0%, 90%, 100% { clip-path: none; transform: none; }
          91% { clip-path: polygon(0 15%, 100% 15%, 100% 30%, 0 30%); transform: translate(-4px, 0); }
          93% { clip-path: polygon(0 60%, 100% 60%, 100% 75%, 0 75%); transform: translate(4px, 0); }
          95% { clip-path: none; transform: none; }
        }
        @keyframes glitch2 {
          0%, 88%, 100% { opacity: 0; }
          89% { opacity: 0.5; transform: translate(6px, -2px); clip-path: polygon(0 40%, 100% 40%, 100% 55%, 0 55%); }
          92% { opacity: 0; }
        }
        @keyframes scanline {
          0% { transform: translateY(-100%); }
          100% { transform: translateY(100vh); }
        }
        @keyframes pulseRing {
          0% { transform: scale(0.8); opacity: 0.8; }
          100% { transform: scale(2.2); opacity: 0; }
        }
        @keyframes fadeSlideUp {
          from { opacity: 0; transform: translateY(30px); }
          to { opacity: 1; transform: translateY(0); }
        }
        .btn-primary:hover { background: oklch(0.48 0.25 280) !important; transform: translateY(-2px); box-shadow: 0 8px 24px oklch(0.55 0.25 280 / 0.4) !important; }
        .btn-secondary:hover { background: oklch(0.18 0.03 280) !important; transform: translateY(-2px); border-color: oklch(0.55 0.25 280) !important; }
        .btn-primary, .btn-secondary { transition: all 0.2s ease; }
      `}</style>

            {/* Deep space background */}
            <div
                style={{
                    position: "absolute", inset: 0,
                    background: `radial-gradient(ellipse at ${mousePos.x * 100}% ${mousePos.y * 100}%, oklch(0.18 0.06 280 / 0.6) 0%, oklch(0.07 0.025 280) 60%)`,
                    transition: "background 0.3s ease",
                }}
            />

            {/* Star field SVG */}
            <StarField />

            {/* Floating particles */}
            <div style={{ position: "absolute", inset: 0, overflow: "hidden", pointerEvents: "none" }}>
                {particles.map((p) => (
                    <FloatingParticle key={p.id} {...p} />
                ))}
            </div>

            {/* Scanline effect */}
            <div
                style={{
                    position: "absolute", inset: 0, pointerEvents: "none",
                    background: "repeating-linear-gradient(0deg, transparent, transparent 3px, oklch(0.55 0.25 280 / 0.015) 3px, oklch(0.55 0.25 280 / 0.015) 4px)",
                }}
            />

            {/* Main content */}
            <div
                style={{
                    position: "relative", zIndex: 10,
                    display: "flex", flexDirection: "column", alignItems: "center",
                    textAlign: "center", padding: "2rem",
                    animation: "fadeSlideUp 0.8s ease forwards",
                }}
            >
                {/* Pulse rings behind astronaut */}
                <div style={{ position: "relative", marginBottom: "2rem" }}>
                    {[1, 2, 3].map((i) => (
                        <div
                            key={i}
                            style={{
                                position: "absolute", top: "50%", left: "50%",
                                width: 200, height: 200,
                                marginLeft: -100, marginTop: -100,
                                borderRadius: "50%",
                                border: "1px solid oklch(0.55 0.25 280 / 0.3)",
                                animation: `pulseRing 3s ease-out ${i * 0.8}s infinite`,
                            }}
                        />
                    ))}
                    <AstronautSVG />
                </div>

                {/* 404 glitch text */}
                <div style={{ position: "relative", marginBottom: "0.5rem" }}>
                    <h1
                        style={{
                            fontFamily: "'Sora', ui-sans-serif, system-ui, sans-serif",
                            fontSize: "clamp(80px, 18vw, 140px)",
                            fontWeight: 800,
                            lineHeight: 1,
                            color: "oklch(0.96 0.01 280)",
                            letterSpacing: "-4px",
                            animation: "glitch1 8s ease-in-out infinite",
                            userSelect: "none",
                        }}
                    >
                        404
                    </h1>
                    {/* Glitch layer */}
                    <h1
                        aria-hidden="true"
                        style={{
                            position: "absolute", top: 0, left: 0,
                            fontFamily: "'Sora', ui-sans-serif, system-ui, sans-serif",
                            fontSize: "clamp(80px, 18vw, 140px)",
                            fontWeight: 800,
                            lineHeight: 1,
                            color: "oklch(0.65 0.25 280)",
                            letterSpacing: "-4px",
                            animation: "glitch2 8s ease-in-out infinite",
                            userSelect: "none",
                        }}
                    >
                        404
                    </h1>
                </div>

                {/* Tag line */}
                <div
                    style={{
                        display: "inline-flex", alignItems: "center", gap: "8px",
                        background: "oklch(0.55 0.25 280 / 0.15)",
                        border: "1px solid oklch(0.55 0.25 280 / 0.3)",
                        borderRadius: "999px",
                        padding: "6px 16px",
                        marginBottom: "1.25rem",
                    }}
                >
                    <div style={{ width: 6, height: 6, borderRadius: "50%", background: "oklch(0.65 0.25 280)", animation: "blink 2s ease-in-out infinite" }} />
                    <span style={{ fontSize: 13, color: "oklch(0.75 0.15 280)", fontWeight: 500, letterSpacing: "0.05em" }}>
                        LOST IN SPACE
                    </span>
                </div>

                <h2
                    style={{
                        fontFamily: "'Sora', ui-sans-serif, system-ui, sans-serif",
                        fontSize: "clamp(20px, 4vw, 28px)",
                        fontWeight: 700,
                        color: "oklch(0.96 0.01 280)",
                        marginBottom: "0.75rem",
                    }}
                >
                    Houston, we have a problem.
                </h2>

                <p
                    style={{
                        fontSize: 15,
                        color: "oklch(0.6 0.04 280)",
                        lineHeight: 1.7,
                        maxWidth: 420,
                        marginBottom: "2.5rem",
                    }}
                >
                    The page you're looking for seems to have drifted into deep space. Don't worry — our crew is on it.
                </p>

                {/* Action buttons */}
                <div style={{ display: "flex", flexWrap: "wrap", gap: "12px", justifyContent: "center", marginBottom: "3rem" }}>
                    <Link
                        to="/"
                        className="btn-primary"
                        style={{
                            display: "inline-flex", alignItems: "center", gap: 8,
                            padding: "12px 24px",
                            background: "oklch(0.55 0.25 280)",
                            color: "white",
                            borderRadius: 12,
                            fontSize: 14,
                            fontWeight: 600,
                            textDecoration: "none",
                            border: "none",
                        }}
                    >
                        <Home size={16} />
                        Back to Home
                    </Link>
                    <Link
                        to="/shop"
                        className="btn-secondary"
                        style={{
                            display: "inline-flex", alignItems: "center", gap: 8,
                            padding: "12px 24px",
                            background: "oklch(0.12 0.025 280)",
                            color: "oklch(0.88 0.02 280)",
                            borderRadius: 12,
                            fontSize: 14,
                            fontWeight: 600,
                            textDecoration: "none",
                            border: "1px solid oklch(0.28 0.04 280)",
                        }}
                    >
                        <ShoppingBag size={16} />
                        Browse Shop
                    </Link>
                </div>

                {/* Quick links */}
                <div
                    style={{
                        display: "flex", flexWrap: "wrap", gap: "8px",
                        justifyContent: "center",
                        padding: "1.5rem 2rem",
                        background: "oklch(0.12 0.025 280 / 0.6)",
                        border: "1px solid oklch(0.22 0.03 280)",
                        borderRadius: 16,
                        backdropFilter: "blur(12px)",
                    }}
                >
                    <span style={{ fontSize: 13, color: "oklch(0.5 0.03 280)", marginRight: 4 }}>
                        Quick links:
                    </span>
                    {[
                        { label: "New Arrivals", to: "/new-arrivals" },
                        { label: "Bestsellers", to: "/bestsellers" },
                        { label: "Sale", to: "/sale" },
                        { label: "Contact Us", to: "/contact" },
                    ].map((link) => (
                        <Link
                            key={link.label}
                            to={link.to}
                            style={{
                                fontSize: 13,
                                color: "oklch(0.65 0.15 280)",
                                textDecoration: "none",
                                padding: "2px 10px",
                                borderRadius: 999,
                                background: "oklch(0.55 0.25 280 / 0.1)",
                                border: "1px solid oklch(0.55 0.25 280 / 0.2)",
                                transition: "all 0.15s ease",
                            }}
                            onMouseEnter={(e) => {
                                e.currentTarget.style.background = "oklch(0.55 0.25 280 / 0.25)"
                                e.currentTarget.style.color = "oklch(0.85 0.15 280)"
                            }}
                            onMouseLeave={(e) => {
                                e.currentTarget.style.background = "oklch(0.55 0.25 280 / 0.1)"
                                e.currentTarget.style.color = "oklch(0.65 0.15 280)"
                            }}
                        >
                            {link.label}
                        </Link>
                    ))}
                </div>
            </div>
            {/* Nexora logo wordmark */}
            <div className="fixed top-10 left-10">
                <Link to="/">
                    <img src={logo} alt="" className="h-25 w-25" />
                </Link>
            </div>
        </div>
    )
}