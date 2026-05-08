import { BrowserRouter, Routes, Route } from 'react-router-dom'
import '@/css/App.css'

import Layout from '@/components/layout';
import Home from '@/pages/home';
import ShopPage from '@/pages/shop';
import CategoriesPage from '@/pages/categories';
import CategoryPage from '@/pages/category';
import ProductPage from '@/pages/product';
import CheckoutPage from '@/pages/checkout/checkout';
import CheckoutSuccessPage from '@/pages/checkout/success/success';
import OrdersPage from '@/pages/order';
import ProfilePage from '@/pages/profile/Profile';
import EditProfilePage from '@/pages/profile/edit/edit-profile';
import ScrollToTop from '@/components/scrollTop';
import LoginPage from '@/pages/login';
import RegisterPage from '@/pages/register';
import CartPage from '@/pages/cart';
import NotFoundPage from './pages/404';
import Protected from '@/routes/Protected';

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
          <Route path="/checkout" element={<Protected><Layout><CheckoutPage /></Layout></Protected>} />
          <Route path="/checkout/success" element={<Layout><CheckoutSuccessPage /></Layout>} />
          <Route path="/orders" element={<Protected><Layout><OrdersPage /></Layout></Protected>} />
          <Route path="/profile" element={<Protected><Layout><ProfilePage /></Layout></Protected>} />
          <Route path="/profile/edit" element={<Protected><Layout><EditProfilePage /></Layout></Protected>} />
          <Route path="/login" element={<Layout><LoginPage /></Layout>} />
          <Route path="/register" element={<Layout><RegisterPage /></Layout>} />
          <Route path="*" element={<NotFoundPage />} />
        </Routes>
      </BrowserRouter>
    </>
  )
}

export default App
