import { createContext, useEffect, useState } from "react";
import api from "@/lib/api"

export const CartContext = createContext();

export const CartProvider = ({ children }) => {
    const [cartData, setCartData] = useState([]);
    useEffect(() => {
        fetchCartData();
    }, []);

    const fetchCartData = () => {
        if (localStorage.getItem("authToken")) {
            api.get("/cart")
                .then((res) => {
                    setCartData(res.data);
                })
                .catch((err) => {
                    console.error("Error fetching cart data:", err);
                });
        } else {
            setCartData([]);
        }
    };
    return (
        <CartContext.Provider
            value={{
                cartData,
                setCartData,
                fetchCartData,
            }}
        >
            {children}
        </CartContext.Provider>
    );
};