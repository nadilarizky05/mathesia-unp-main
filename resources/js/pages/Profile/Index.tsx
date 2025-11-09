import { Head, usePage, router } from "@inertiajs/react";
import Navigation from "@/components/navigation";
import { motion } from "framer-motion";
import { Edit, Mail, User, Shield, LogOut } from "lucide-react";

interface User {
  id: number;
  name: string;
  email: string;
  avatar_url?: string | null;
  role?: string;
}

interface PageProps {
  auth: { user: User };
  [key: string]: any;
}

export default function ProfilePage() {
  const { auth } = usePage<PageProps>().props;
  const user = auth.user;

  const handleLogout = () => router.post("/logout");

  return (
    <div className="min-h-screen bg-gray-50">
      <Head title="Profil Saya" />
      <Navigation />

      <motion.div
        initial={{ opacity: 0, y: 20 }}
        animate={{ opacity: 1, y: 0 }}
        transition={{ duration: 0.5 }}
        className="max-w-4xl mx-auto px-6 py-10"
      >
        <div className="bg-white rounded-2xl shadow-lg p-8 flex flex-col items-center text-center">
          {/* Avatar */}
          <div className="relative">
            <div className="w-28 h-28 rounded-full bg-[#2f6a62] text-white flex items-center justify-center text-4xl font-bold">
              {user.name.charAt(0).toUpperCase()}
            </div>
            {/* <button className="absolute bottom-0 right-0 bg-[#2f6a62] text-white p-2 rounded-full shadow hover:bg-[#245950] transition">
              <Edit size={16} />
            </button> */}
          </div>

          {/* User Info */}
          <h1 className="text-2xl font-semibold text-gray-800 mt-4">
            {user.name}
          </h1>
          {user.role && (
            <p className="text-sm text-gray-500 capitalize mt-1">
              {user.role}
            </p>
          )}

          <div className="mt-6 w-full grid grid-cols-1 sm:grid-cols-2 gap-4 text-left">
            <div className="flex items-center gap-3 bg-gray-50 p-4 rounded-xl border border-gray-100">
              <User className="text-[#2f6a62]" />
              <div>
                <p className="text-sm text-gray-500">Nama Lengkap</p>
                <p className="text-gray-800 font-medium">{user.name}</p>
              </div>
            </div>

            <div className="flex items-center gap-3 bg-gray-50 p-4 rounded-xl border border-gray-100">
              <Mail className="text-[#2f6a62]" />
              <div>
                <p className="text-sm text-gray-500">Email</p>
                <p className="text-gray-800 font-medium">{user.email}</p>
              </div>
            </div>

            <div className="flex items-center gap-3 bg-gray-50 p-4 rounded-xl border border-gray-100">
              <Shield className="text-[#2f6a62]" />
              <div>
                <p className="text-sm text-gray-500">Peran</p>
                <p className="text-gray-800 font-medium capitalize">
                  {user.role || "Tidak diketahui"}
                </p>
              </div>
            </div>
          </div>

          <button
            onClick={handleLogout}
            className="mt-8 flex items-center gap-2 px-5 py-2.5 bg-red-500 text-white rounded-xl hover:bg-red-600 transition"
          >
            <LogOut size={18} />
            <span>Keluar</span>
          </button>
        </div>
      </motion.div>
    </div>
  );
}
