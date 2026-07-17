import { createContext, useEffect, useState } from "react";
import api from "@/lib/api"

export const AuthContext = createContext();

export const AuthProvider = ({ children }) => {
    const [userData, setUserData] = useState(null)
    useEffect(() => {
        fetchUserData();
    }, []);

    const fetchUserData = () => {
        api.get("/user")
            .then((res) => {
                if (res.status === 200) {
                    api.get("/profile")
                        .then((response) => {
                            setUserData(response.data)
                        })
                        .catch((e) => {
                            console.error("Error fetching User data:", e)
                        })
                }
            })
            .catch((err) => {
                setUserData(null);
            });
    };
    return (
        <AuthContext.Provider
            value={{
                userData,
                setUserData,
                fetchUserData,
            }}
        >
            {children}
        </AuthContext.Provider>
    );
};