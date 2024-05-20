import { Routes, Route, Navigate } from 'react-router-dom';
import Dashboard from './pages/Dashboard';
import ProtectedRoute from './components/Helper/ProtectedRoute';
import Login from './pages/Auth/Login';
import NotFound from './components/NotFound';
import Configurations from './pages/Configurations';
import NewService from './pages/Services/NewService';
import Customers from './pages/Customers';
import ShowCustomers from './pages/Customers/Show';
import CreateCustomer from './pages/Customers/Create';
import EditCustomer from './pages/Customers/Edit';
import Handout from './pages/Handout';
import Services from './pages/Services';
import Calendar from './pages/Calendar';
import Declarations from './pages/Declarations';
import Products from './pages/Products';
import Reports from './pages/Reports';
import Payments from './pages/Payments';

export default function MainRoutes() {
  return (
    <Routes>
      <Route path="/" index element={<Navigate to="/dashboard" />} />
      <Route path="/login/*" element={<Login />} />
      <Route
        path="/dashboard"
        exact
        element={
          <ProtectedRoute>
            <Dashboard />
          </ProtectedRoute>
        }
      />

      <Route path="/customers">
        <Route
          path=""
          element={
            <ProtectedRoute>
              <Customers />
            </ProtectedRoute>
          }
        />
        <Route
          path="create"
          element={
            <ProtectedRoute>
              <CreateCustomer />
            </ProtectedRoute>
          }
        />
        <Route
          path=":customerId"
          element={
            <ProtectedRoute>
              <ShowCustomers />
            </ProtectedRoute>
          }
        />
        <Route
          path=":customerId/edit"
          element={
            <ProtectedRoute>
              <EditCustomer />
            </ProtectedRoute>
          }
        />
      </Route>

      <Route path="/services">
        <Route
          path=""
          element={
            <ProtectedRoute>
              <Services />
            </ProtectedRoute>
          }
        />
        <Route
          path="create/:customerId"
          element={
            <ProtectedRoute>
              <NewService />
            </ProtectedRoute>
          }
        />
      </Route>

      <Route
        path="/calendar"
        exact
        element={
          <ProtectedRoute>
            <Calendar />
          </ProtectedRoute>
        }
      />

      <Route
        path="/payments"
        exact
        element={
          <ProtectedRoute>
            <Payments />
          </ProtectedRoute>
        }
      />

      <Route
        path="/declarations"
        exact
        element={
          <ProtectedRoute>
            <Declarations />
          </ProtectedRoute>
        }
      />

      <Route
        path="/handout"
        exact
        element={
          <ProtectedRoute>
            <Handout />
          </ProtectedRoute>
        }
      />

      <Route
        path="/products"
        exact
        element={
          <ProtectedRoute>
            <Products />
          </ProtectedRoute>
        }
      />

      <Route
        path="/reports"
        exact
        element={
          <ProtectedRoute>
            <Reports />
          </ProtectedRoute>
        }
      />

      <Route
        path="/configurations"
        exact
        element={
          <ProtectedRoute>
            <Configurations />
          </ProtectedRoute>
        }
      />
      <Route path="*" element={<NotFound />} />
    </Routes>
  );
}
