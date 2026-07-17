import { useEffect, useState } from 'react'
import { ChevronRight, Home } from 'lucide-react'
import { Button } from '@/components/ui/button'
import { Link } from 'react-router-dom'

export default function NotFound() {
  const [mounted, setMounted] = useState(false)
  const [mousePos, setMousePos] = useState({ x: 0, y: 0 })

  useEffect(() => {
    setMounted(true)
  }, [])

  useEffect(() => {
    const handleMouseMove = (e) => {
      setMousePos({
        x: e.clientX / window.innerWidth,
        y: e.clientY / window.innerHeight,
      })
    }

    window.addEventListener('mousemove', handleMouseMove)
    return () => window.removeEventListener('mousemove', handleMouseMove)
  }, [])

  if (!mounted) return null

  return (
    <div className="min-h-screen bg-background overflow-hidden relative flex items-center justify-center">
      {/* Animated background elements */}
      <div className="absolute inset-0 overflow-hidden">
        {/* Gradient orbs */}
        <div
          className="absolute -top-40 -right-40 w-80 h-80 rounded-full bg-gradient-to-br from-primary/20 to-transparent blur-3xl animate-pulse"
          style={{
            animation: 'float 6s ease-in-out infinite',
            transform: `translate(${mousePos.x * 20}px, ${mousePos.y * 20}px)`,
          }}
        />
        <div
          className="absolute -bottom-40 -left-40 w-80 h-80 rounded-full bg-gradient-to-tr from-primary/10 to-transparent blur-3xl"
          style={{
            animation: 'float 8s ease-in-out infinite reverse',
            transform: `translate(${mousePos.x * -15}px, ${mousePos.y * -15}px)`,
          }}
        />
        <div
          className="absolute top-1/2 left-1/2 w-96 h-96 rounded-full bg-gradient-to-br from-accent/5 to-transparent blur-3xl"
          style={{
            animation: 'float 10s ease-in-out infinite',
            transform: `translate(-50%, -50%) translate(${mousePos.x * 10}px, ${mousePos.y * 10}px)`,
          }}
        />
      </div>

      {/* Content */}
      <div className="relative z-10 w-full px-4 sm:px-6">
        <div className="max-w-2xl mx-auto text-center">
          {/* Animated 404 text */}
          <div className="mb-8 relative">
            <div
              className="text-9xl sm:text-10xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-primary via-primary to-primary/70"
              style={{
                fontFamily: 'var(--font-heading)',
                animation: 'fadeInScale 0.8s ease-out',
                textShadow: '0 10px 40px rgba(79, 70, 229, 0.2)',
              }}
            >
              404
            </div>

            {/* Floating icons animation */}
            <div className="absolute inset-0 flex items-center justify-center">
              <div
                className="text-6xl"
                style={{
                  animation: 'bounce 2s ease-in-out infinite',
                }}
              >
                🌪️
              </div>
            </div>
          </div>

          {/* Heading */}
          <div className="mb-4 space-y-2">
            <h1
              className="text-4xl sm:text-5xl font-bold text-foreground"
              style={{
                fontFamily: 'var(--font-heading)',
                animation: 'fadeInUp 0.8s ease-out 0.2s both',
              }}
            >
              Page Not Found
            </h1>
            <p
              className="text-lg sm:text-xl text-muted-foreground max-w-md mx-auto"
              style={{
                animation: 'fadeInUp 0.8s ease-out 0.4s both',
              }}
            >
              Oops! It seems like you've ventured into uncharted territory. The page you're looking for doesn't exist.
            </p>
          </div>

          {/* Decorative line */}
          <div
            className="my-8 flex items-center justify-center gap-4"
            style={{
              animation: 'fadeInUp 0.8s ease-out 0.6s both',
            }}
          >
            <div className="w-12 h-0.5 bg-gradient-to-r from-transparent to-primary/50" />
            <div className="w-2 h-2 rounded-full bg-primary/50" />
            <div className="w-12 h-0.5 bg-gradient-to-l from-transparent to-primary/50" />
          </div>

          {/* Action buttons */}
          <div
            className="flex flex-col sm:flex-row items-center justify-center gap-4 mt-10"
            style={{
              animation: 'fadeInUp 0.8s ease-out 0.8s both',
            }}
          >
            <Button
              size="lg"
              asChild
              className="gap-2 group relative overflow-hidden"
            >
              <Link to={"/"}>
                <Home className="h-5 w-5 group-hover:scale-110 transition-transform" />
                <span>Back to Home</span>
                <ChevronRight className="h-5 w-5 group-hover:translate-x-1 transition-transform" />
              </Link>
            </Button>

            <Button
              size="lg"
              variant="outline"
              asChild
              className="gap-2 group"
            >
              <Link to={"/shop"}>
                <span>Continue Shopping</span>
                <ChevronRight className="h-5 w-5 group-hover:translate-x-1 transition-transform" />
              </Link>
            </Button>
          </div>

          {/* Additional help text */}
          <div
            className="mt-12 space-y-2 text-sm text-muted-foreground"
            style={{
              animation: 'fadeInUp 0.8s ease-out 1s both',
            }}
          >
            <p>Need help? Visit our support center or contact our team.</p>
            <div className="flex items-center justify-center gap-4">
              <Link href="/support" className="hover:text-foreground transition-colors duration-300">
                Support
              </Link>
              <span>•</span>
              <Link href="/contact" className="hover:text-foreground transition-colors duration-300">
                Contact Us
              </Link>
              <span>•</span>
              <Link href="/faq" className="hover:text-foreground transition-colors duration-300">
                FAQ
              </Link>
            </div>
          </div>

          {/* Floating particles */}
          <div className="absolute inset-0 pointer-events-none">
            {[...Array(5)].map((_, i) => (
              <div
                key={i}
                className="absolute w-1 h-1 bg-primary/30 rounded-full"
                style={{
                  left: `${Math.random() * 100}%`,
                  top: `${Math.random() * 100}%`,
                  animation: `float${i % 2 === 0 ? '1' : '2'} ${4 + i}s ease-in-out infinite`,
                }}
              />
            ))}
          </div>
        </div>
      </div>

      {/* CSS Animations */}
      <style jsx>{`
        @keyframes fadeInScale {
          from {
            opacity: 0;
            transform: scale(0.5);
          }
          to {
            opacity: 1;
            transform: scale(1);
          }
        }

        @keyframes fadeInUp {
          from {
            opacity: 0;
            transform: translateY(20px);
          }
          to {
            opacity: 1;
            transform: translateY(0);
          }
        }

        @keyframes bounce {
          0%,
          100% {
            transform: translateY(0);
          }
          50% {
            transform: translateY(-20px);
          }
        }

        @keyframes float {
          0%,
          100% {
            transform: translateY(0px);
          }
          50% {
            transform: translateY(-30px);
          }
        }

        @keyframes float1 {
          0%,
          100% {
            transform: translate(0, 0);
            opacity: 0.5;
          }
          50% {
            transform: translate(30px, -30px);
            opacity: 1;
          }
        }

        @keyframes float2 {
          0%,
          100% {
            transform: translate(0, 0);
            opacity: 0.5;
          }
          50% {
            transform: translate(-30px, 30px);
            opacity: 1;
          }
        }
      `}</style>
    </div>
  )
}
