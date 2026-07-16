import { Link } from "react-router-dom"
import { ChevronRight } from "lucide-react"
import { Button } from "@/components/ui/button"

export function StatCard({ label, value, icon: Icon }) {
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

export function MenuItem({ item, badge }) {
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
                {badge ? (
                    <span className="flex h-6 w-6 items-center justify-center rounded-full bg-primary text-xs font-medium text-primary-foreground">
                        {badge}
                    </span>
                ) : null}
                <ChevronRight className="h-5 w-5 text-muted-foreground" />
            </div>
        </Link>
    )
}
