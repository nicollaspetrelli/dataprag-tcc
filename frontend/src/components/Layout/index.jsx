import React from 'react'
import Header from '../Header';
import SideBar from '../Sidebar';

export default function Layout({ children }) {
    return (
      <div className="flex">
        <SideBar />
        <div className="flex h-screen w-screen bg-jett-400 dark:bg-astro-900 overflow-hidden">
              <div className="flex flex-col flex-1 w-full">
                  <Header/>

                  <main className="h-full overflow-y-auto">
                      <div className="container px-6 mx-auto grid max-w-full">
                          {children}
                      </div>
                  </main>
              </div>
        </div>
      </div>
    )
}