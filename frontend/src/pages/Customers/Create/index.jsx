import React from 'react'
import Layout from '../../../components/Layout'
import Tabs from '../../../components/Tabs';
import CustomerForm from '../form';
import { TabItems, legalRules, defaultCustomerEmpty, CUSTOMER_KIT, individualRule } from '../definitions';

export default function CreateCustomer() {
    const [activeTabIndex, setActiveTabIndex] = React.useState(0)

    return (
        <Layout>
            <div className="flex flex-wrap mt-5">
                <Tabs items={TabItems} activeIndex={activeTabIndex} setActiveIndex={setActiveTabIndex} />

                <div className="p-5 mb-8 mt-4 bg-white rounded-lg shadow-md dark:bg-astro-800 loading w-full">
                    {activeTabIndex === 0 && <CustomerForm customerType={CUSTOMER_KIT.legal} rules={legalRules.safe} restrictMode formData={defaultCustomerEmpty} />}
                    {activeTabIndex === 1 && <CustomerForm customerType={CUSTOMER_KIT.individual} rules={individualRule} restrictMode formData={defaultCustomerEmpty} />}
                </div>
            </div>
        </Layout>
    )
}