import Profile from './Profile';
import Notifications from './Notifications';

export default function Header() {
  return (
    <header className="py-4 bg-white shadow-lg dark:bg-astro-800 z-10 ">
      <div className="flex items-center justify-end w-full h-full px-6 text-skye-600">
        <ul className="flex items-center flex-shrink-0 space-x-6">
          <li className="flex">
            <Notifications />
          </li>
          <li className="flex">
            <Profile />
          </li>
        </ul>
      </div>
    </header>
  );
}
