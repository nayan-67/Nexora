import React from 'react'
import { Header } from './header'
import { Footer } from './footer'

export default function Layout({ children }) {
    return (
        <>
            <Header />
            {/* <main className="flex-1">
            </main> */}
            {children}
            <Footer />
        </>
    )
}
