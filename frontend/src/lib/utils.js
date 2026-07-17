import { clsx } from 'clsx';
import { twMerge } from 'tailwind-merge';

export function cn(...inputs) {
    return twMerge(clsx(inputs));
}

export function formatCurrency(amount, currency = 'USD', options) {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency,
        ...options,
    }).format(amount);
}

export function generateUniqueId(prefix = 'id') {
    return `${prefix}-${Math.random().toString(36).slice(2, 9)}`;
}

export function truncateText(text, maxLength) {
    if (typeof text !== 'string') {
        return '';
    }

    if (text.length <= maxLength) {
        return text;
    }

    return `${text.slice(0, maxLength)}...`;
}

export function formatDate(date, options) {
    return new Intl.DateTimeFormat('en-US', {
        day: 'numeric',
        month: 'short',
        year: 'numeric',
        ...options,
    }).format(date);
}

export function debounce(func, wait = 0) {
    let timeout = null;

    return (...args) => {
        if (timeout !== null) {
            clearTimeout(timeout);
        }

        timeout = setTimeout(() => {
            timeout = null;
            func(...args);
        }, wait);
    };
}

export function throttle(func, limit = 0) {
    let inThrottle = false;

    return (...args) => {
        if (inThrottle) {
            return;
        }

        inThrottle = true;
        func(...args);

        setTimeout(() => {
            inThrottle = false;
        }, limit);
    };
}
