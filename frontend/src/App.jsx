import { BrowserRouter, Routes, Route } from 'react-router-dom'
import './App.css'

import Layout from '@/components/layout';
import Home from '@/pages/home';
import ShopPage from '@/pages/shop';
import CategoriesPage from '@/pages/categories';
import CategoryPage from '@/pages/category';
import ProductPage from '@/pages/product';
import CheckoutPage from '@/pages/checkout/checkout';
import CheckoutSuccessPage from '@/pages/checkout/success';
import OrdersPage from '@/pages/profile/orders/order';
import OrderDetailPage from '@/pages/profile/orders/items/page';
import CancelOrderPage from '@/pages/profile/orders/cancel/page';
import ReturnPage from '@/pages/profile/orders/return/page';
import ProfilePage from '@/pages/profile/Profile';
import EditProfilePage from '@/pages/profile/edit-profile';
import ScrollToTop from '@/components/scrollTop';
import LoginPage from '@/pages/Auth/login';
import RegisterPage from '@/pages/Auth/register';
import CartPage from '@/pages/cart';
import NotFoundPage from '@/pages/404/page';
import Protected from '@/routes/Protected';
import PaymentMethodsPage from '@/pages/profile/payment/payment';
import ManageAddressesPage from '@/pages/profile/address/address';
import SecurityPage from '@/pages/profile/security/security';
import WishlistPage from '@/pages/profile/wishlist/wishlist';

function App() {

  return (
    <>
      <BrowserRouter>
        <ScrollToTop />
        <Routes>
          <Route path="/" element={<Layout><Home /></Layout>} />
          <Route path="/shop" element={<Layout><ShopPage /></Layout>} />
          <Route path="/categories" element={<Layout><CategoriesPage /></Layout>} />
          <Route path="/category/:slug" element={<Layout><CategoryPage /></Layout>} />
          <Route path="/products/:id" element={<Layout><ProductPage /></Layout>} />
          <Route path="/cart" element={<Layout><CartPage /></Layout>} />
          <Route path="/wishlist" element={<Layout><WishlistPage /></Layout>} />
          <Route path="/checkout" element={<Protected><Layout><CheckoutPage /></Layout></Protected>} />
          <Route path="/checkout/success/:ordid" element={<Protected><Layout><CheckoutSuccessPage /></Layout></Protected>} />
          <Route path="/orders" element={<Protected><Layout><OrdersPage /></Layout></Protected>} />
          <Route path="/orders/:id" element={<Protected><Layout><OrderDetailPage /></Layout></Protected>} />
          <Route path="/orders/return/:id" element={<Protected><Layout><ReturnPage /></Layout></Protected>} />
          <Route path="/profile" element={<Protected><Layout><ProfilePage /></Layout></Protected>} />
          <Route path="/profile/edit" element={<Protected><Layout><EditProfilePage /></Layout></Protected>} />
          <Route path="/profile/payment" element={<Protected><Layout><PaymentMethodsPage /></Layout></Protected>} />
          <Route path="/profile/addresses" element={<Protected><Layout><ManageAddressesPage /></Layout></Protected>} />
          <Route path="/profile/security" element={<Protected><Layout><SecurityPage /></Layout></Protected>} />
          <Route path="/login" element={<Layout><LoginPage /></Layout>} />
          <Route path="/register" element={<Layout><RegisterPage /></Layout>} />
          <Route path="*" element={<NotFoundPage />} />
        </Routes>
      </BrowserRouter>
    </>
  )
}

export default App
