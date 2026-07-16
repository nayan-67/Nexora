import { Navigate, useLocation } from "react-router-dom";
import { AuthContext } from "@/context/AuthContext"
// import { useContext } from "react";

export default function Protected({ children }) {
  const token = localStorage.getItem("authToken");
  // const { userData } = useContext(AuthContext)
  const location = useLocation();
  if (!token) {
    return <Navigate to="/login" state={{ from: location }} replace />;
  }

  return children;
}