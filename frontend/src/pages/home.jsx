import React, { useEffect } from 'react'
import { HeroSection } from '../components/hero-section'
import { FeaturesSection } from '../components/features-section'
import { CategoriesSection } from '../components/categories-section'
import { FeaturedProducts } from '../components/featured-products'
import { TestimonialsSection } from '../components/testimonials-section'
import { NewsletterSection } from '../components/newsletter-section'
import { useLocation } from 'react-router-dom'
import toast from 'react-hot-toast'

export default function Home() {
    const location = useLocation();
    useEffect(() => {
        if (location.state?.loginSuccess) {
            toast.success("Login successful!");
            location.state.loginSuccess = false;
        }
        if (location.state?.logout) {
            toast.success("You have been logged out.");
            location.state.logout = false;
        }
    }, []);
    return (
        <>
            <HeroSection />
            <FeaturesSection />
            <CategoriesSection />
            <FeaturedProducts />
            <TestimonialsSection />
            <NewsletterSection />
        </>
    )
}
