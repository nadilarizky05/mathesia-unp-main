import { motion } from 'framer-motion';
import Navigation from '@/components/navigation';

interface ErrorLayoutProps {
  code: number;
  title: string;
  message: string;
}

export default function ErrorLayout({ code, title, message }: ErrorLayoutProps) {
  return (
    <div className="min-h-screen bg-[#f8faf9] flex flex-col">
      <Navigation />

      <div className="flex flex-1 items-center justify-center px-6 py-12">
        <motion.div
          initial={{ opacity: 0, y: 20 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.4 }}
          className="max-w-md w-full text-center bg-white rounded-2xl shadow-lg p-10 border border-gray-100"
        >
          <motion.h1
            initial={{ scale: 0.9 }}
            animate={{ scale: 1 }}
            transition={{ duration: 0.3 }}
            className="text-8xl font-extrabold text-[#2f6a62]"
          >
            {code}
          </motion.h1>

          <h2 className="mt-4 text-2xl font-bold text-gray-800">{title}</h2>

          <p className="mt-2 text-gray-500">{message}</p>

          <a
            href="/"
            className="mt-6 inline-block rounded-full bg-[#2f6a62] px-6 py-2 text-sm font-semibold text-white shadow hover:bg-[#24544e] transition"
          >
            Kembali ke Beranda
          </a>
        </motion.div>
      </div>

      <footer className="pb-6 text-center text-sm text-gray-400">
        &copy; {new Date().getFullYear()} Mathesia Learning
      </footer>
    </div>
  );
}
