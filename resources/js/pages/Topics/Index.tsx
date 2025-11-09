import Navigation from "@/components/navigation";
import { Link, usePage, Head } from "@inertiajs/react";
import { motion } from "framer-motion";
import { BookOpen, ArrowRight } from "lucide-react";

interface Topic {
  id: number;
  title: string;
  description?: string;
  image?: string;
}

export default function TopicsIndex() {
  const { topics } = usePage().props as unknown as { topics: Topic[] };

  return (
    <div className="min-h-screen bg-[#f8faf9]" style={{ fontFamily: 'Poppins, sans-serif' }}>
      <Head title="Learning Material" />
      <Navigation />

      <main className="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        {/* Header Section */}
        <motion.div 
          className="text-center mb-12"
          initial={{ opacity: 0, y: -20 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.5 }}
        >
          {/* <div className="inline-flex items-center justify-center w-16 h-16 bg-[#2f6a62] rounded-full mb-4">
            <BookOpen className="w-8 h-8 text-white" />
          </div> */}
          <h2 className="text-4xl font-bold text-gray-900 mb-3">
            Pilih Topik Belajar
          </h2>
          {/* <p className="text-lg text-gray-600 max-w-2xl mx-auto">
            Pilih topik sesuai minatmu untuk mulai belajar!
          </p> */}
          <div className="mx-auto mt-4 h-1 w-24 bg-gradient-to-r from-transparent via-[#2f6a62] to-transparent"></div>
        </motion.div>

        {/* Topics Grid */}
        <div className={`grid gap-6 ${
          topics.length === 1 
            ? 'grid-cols-1 max-w-2xl mx-auto' 
            : topics.length === 2
            ? 'grid-cols-1 md:grid-cols-2 max-w-4xl mx-auto'
            : 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-3'
        }`}>
          {topics.map((topic, index) => (
            <motion.div
              key={topic.id}
              initial={{ opacity: 0, y: 20 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ delay: index * 0.1, duration: 0.5 }}
            >
              <Link
                href={`/topics/${topic.id}/subtopics`}
                className="group block bg-white rounded-2xl shadow-md hover:shadow-2xl transition-all duration-300 overflow-hidden h-full hover:-translate-y-2"
              >
                {/* Image Section */}
                {topic.image && (
                  <div className="relative h-48 overflow-hidden bg-gradient-to-br from-[#2f6a62] to-[#1e4540]">
                    <img
                      src={topic.image}
                      alt={topic.title}
                      className="w-full h-full object-cover opacity-90 group-hover:scale-110 transition-transform duration-500"
                    />
                    <div className="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
                  </div>
                )}

                {/* Content Section */}
                <div className="p-6">
                  <h3 className="text-xl font-bold text-gray-900 mb-3 group-hover:text-[#2f6a62] transition-colors">
                    {topic.title}
                  </h3>
                  
                  {topic.description && (
                    <p className="text-gray-600 text-sm leading-relaxed mb-4">
                      {topic.description}
                    </p>
                  )}

                  {/* Call to Action */}
                  <div className="flex items-center text-[#2f6a62] font-semibold text-sm group-hover:gap-3 gap-2 transition-all">
                    <span>Mulai Belajar</span>
                    <ArrowRight className="w-4 h-4 group-hover:translate-x-1 transition-transform" />
                  </div>
                </div>

                {/* Bottom Accent */}
                <div className="h-1 bg-gradient-to-r from-[#2f6a62] via-[#3d8377] to-[#2f6a62] transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
              </Link>
            </motion.div>
          ))}
        </div>

        {/* Empty State (optional) */}
        {topics.length === 0 && (
          <motion.div
            initial={{ opacity: 0 }}
            animate={{ opacity: 1 }}
            className="text-center py-20"
          >
            <div className="inline-flex items-center justify-center w-20 h-20 bg-gray-100 rounded-full mb-4">
              <BookOpen className="w-10 h-10 text-gray-400" />
            </div>
            <h3 className="text-xl font-semibold text-gray-700 mb-2">
              Belum Ada Topik
            </h3>
            <p className="text-gray-500">
              Topik pembelajaran akan segera tersedia.
            </p>
          </motion.div>
        )}

        {/* Additional Info Section (untuk mengurangi white space) */}
        {topics.length > 0 && (
          <motion.div
            initial={{ opacity: 0, y: 20 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ delay: 0.3, duration: 0.5 }}
            className="mt-16 bg-gradient-to-r from-[#2f6a62] to-[#3d8377] rounded-2xl p-8 text-white text-center"
          >
            <h3 className="text-2xl font-bold mb-3">
              Siap Memulai Perjalanan Belajarmu?
            </h3>
            <p className="text-white/90 mb-6 max-w-2xl mx-auto">
              Setiap topik dirancang khusus untuk membantu kamu memahami konsep matematika dengan cara yang menyenangkan dan interaktif.
            </p>
            <div className="flex flex-wrap justify-center gap-8 mt-8">
              <div className="text-center">
                <div className="text-3xl font-bold mb-1">{topics.length}</div>
                <div className="text-sm text-white/80">Topik Tersedia</div>
              </div>
              <div className="text-center">
                <div className="text-3xl font-bold mb-1">∞</div>
                <div className="text-sm text-white/80">Pembelajaran</div>
              </div>
              <div className="text-center">
                <div className="text-3xl font-bold mb-1">★</div>
                <div className="text-sm text-white/80">Interaktif</div>
              </div>
            </div>
          </motion.div>
        )}
      </main>
    </div>
  );
}