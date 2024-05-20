import React from 'react';
import { useParams } from 'react-router-dom';
// import { Toast } from 'primereact/toast';
import Layout from '../../../components/Layout';
import Tabs from '../../../components/Tabs';
import CustomerForm from '../form';
import NotFound from '../../../components/NotFound';
import { fetchCustomer } from '../../../services/CustomerService';
import {
  ReturnTabItems,
  legalRules,
  CUSTOMER_KIT,
  individualRule,
} from '../definitions';

export default function EditCustomer() {
  const { customerId } = useParams();
  const [notFound, setNotFound] = React.useState(false);
  const [customer, setCustomer] = React.useState(null);
  const [tabItems, setTabItems] = React.useState([]);
  const [activeTabIndex, setActiveTabIndex] = React.useState(0);

  // TODO: REFACTOR THIS TO REACT QUERY
  async function SearchCustomer() {
    await fetchCustomer(customerId)
      .then((response) => {
        setCustomer(response.data);
        setTabItems(ReturnTabItems(response.data.type));

        const type = parseInt(response.data.type, 10);

        if (type === 0) {
          setActiveTabIndex(0);
          return;
        }

        if (type === 1) {
          setActiveTabIndex(1);
          return;
        }

        setNotFound(true);
      })
      .catch((error) => {
        console.log(error);
        setNotFound(true);
      });
  }

  React.useEffect(() => {
    SearchCustomer();
  }, []);

  if (notFound) {
    return <NotFound />;
  }

  return (
    <Layout>
      <div className="flex flex-wrap mt-5">
        <Tabs
          items={tabItems}
          activeIndex={activeTabIndex}
          setActiveIndex={setActiveTabIndex}
        />

        <div className="p-5 mb-8 mt-4 bg-white rounded-lg shadow-md dark:bg-astro-800 loading w-full">
          {activeTabIndex === 0 && (
            <CustomerForm
              editingMode
              customerType={CUSTOMER_KIT.legal}
              rules={legalRules.safe}
              restrictMode
              formData={customer}
            />
          )}
          {activeTabIndex === 1 && (
            <CustomerForm
              editingMode
              customerType={CUSTOMER_KIT.individual}
              rules={individualRule}
              restrictMode
              formData={customer}
            />
          )}
        </div>
      </div>
    </Layout>
  );
}
