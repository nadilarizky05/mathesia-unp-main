import { useForm, usePage } from "@inertiajs/react";
import { useState } from "react";
import Swal from "sweetalert2";
import toast from "react-hot-toast";

interface GameProps {
  subtopic: {
    id: number;
    title: string;
    thumbnail?: string | null;
  };
  game_url?: string | null;
  level?: string; 
}

export default function GamePlay() {
  const { subtopic, game_url, level } = usePage().props as unknown as GameProps;
  const { data, setData, post, processing, errors, reset } = useForm({
    access_code: "",
  });
  const [loading, setLoading] = useState(false);

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    setLoading(true);

    post(`/game/verify/${subtopic.id}`, {
      preserveScroll: true,
      onSuccess: () => {
        setLoading(false);
        Swal.fire({
          icon: "success",
          title: "Kode Akses Terverifikasi! ✓",
          text: "Selamat! Kamu berhasil membuka akses materi baru.",
          confirmButtonText: "Mulai Belajar",
          confirmButtonColor: "rgb(47,106,98)",
          customClass: {
            popup: 'swal-poppins'
          }
        }).then(() => {
          toast.success("Kode berhasil diverifikasi!");
        });
      },
      onError: () => {
        setLoading(false);
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: errors.access_code || "Kode tidak valid.",
          confirmButtonColor: "#ef4444",
          customClass: {
            popup: 'swal-poppins'
          }
        });
        reset("access_code");
      },
    });
  };

  return (
    <div className="bg-[rgb(224,234,232)] min-h-screen" style={{ fontFamily: 'Poppins, sans-serif' }}>
      <main className="container mx-auto px-4 py-8 md:py-12">
        <h1 className="text-3xl md:text-4xl font-bold text-center text-[rgb(47,106,98)] mb-8 md:mb-12">
          Game Test - {subtopic.title}
        </h1>

        <div className="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8">
          {/* LEFT: Game Frame */}
          <div className="bg-white rounded-2xl shadow-lg p-4 md:p-6 flex justify-center items-center">
            {game_url ? (
              <div className="w-full">
                <div className="w-full rounded-xl overflow-hidden border">
                  <iframe
                    src={game_url}
                    title={subtopic.title}
                    className="w-full h-[450px] md:h-[600px] rounded-xl"
                    sandbox="allow-scripts allow-forms allow-popups allow-popups-to-escape-sandbox allow-same-origin"
                    allowFullScreen
                  />
                </div>
                <p className="text-sm text-gray-500 mt-2 text-center">
                  Jika website tidak muncul, buka di tab baru:&nbsp;
                  <a
                    href={game_url}
                    target="_blank"
                    rel="noopener noreferrer"
                    className="text-[rgb(47,106,98)] underline"
                  >
                    Buka di tab baru
                  </a>
                </p>
              </div>
            ) : subtopic.thumbnail ? (
              <img
                src={subtopic.thumbnail}
                alt={subtopic.title}
                className="rounded-xl w-full max-h-[450px] object-cover"
              />
            ) : (
              <div className="text-gray-400 italic">Tidak ada game yang tersedia</div>
            )}
          </div>

          {/* RIGHT: Info + Code Input */}
          <div className="flex flex-col gap-6">
            <div className="bg-white rounded-2xl shadow-lg p-6 md:p-8">
              <p className="text-gray-700 text-center leading-relaxed mb-6">
                Sebelum mulai belajar, selesaikan game tes berikut untuk
                menentukan kategori materi belajar kamu. Setelah itu, masukkan{" "}
                <b className="text-[rgb(47,106,98)]">6 kode unik</b> dari
                tantangan game tersebut.
              </p>

              
            </div>

            <div className="bg-white rounded-2xl shadow-lg p-6 md:p-8">
              <form onSubmit={handleSubmit}>
                <h3 className="text-2xl font-bold text-[rgb(47,106,98)] mb-4 text-center">
                  Masukkan Codenya disini
                </h3>

                <input
                  type="text"
                  maxLength={6}
                  value={data.access_code.toUpperCase()}
                  onChange={(e) =>
                    setData("access_code", e.target.value.toUpperCase())
                  }
                  className="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-[rgb(47,106,98)] focus:ring-2 focus:ring-[rgb(47,106,98)] focus:ring-opacity-20 outline-none transition-all text-center text-lg font-semibold uppercase tracking-wider text-gray-800"
                  required
                />

                {errors.access_code && (
                  <p className="text-red-500 text-sm mt-2 text-center">
                    {errors.access_code}
                  </p>
                )}

                <button
                  type="submit"
                  disabled={processing || loading}
                  className="w-full mt-6 bg-[rgb(47,106,98)] hover:bg-[rgb(37,86,78)] text-white font-semibold rounded-full py-3 px-6 transition-all duration-300 transform hover:scale-105 shadow-md disabled:opacity-50 disabled:cursor-not-allowed"
                >
                  {loading ? "Memproses..." : "Cek Hasil Tes"}
                </button>
              </form>
            </div>
          </div>
        </div>

        {/* Back Button */}
        <div className="mt-8 text-center">
          <a
            href="/topics"
            className="inline-flex items-center text-[rgb(47,106,98)] hover:text-[rgb(37,86,78)] font-medium transition-colors duration-300"
          >
            <svg
              className="w-5 h-5 mr-2"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                strokeLinecap="round"
                strokeLinejoin="round"
                strokeWidth="2"
                d="M15 19l-7-7 7-7"
              />
            </svg>
            Kembali ke Learning Material
          </a>
        </div>
      </main>

      <style>{`
        .swal-poppins {
          font-family: 'Poppins', sans-serif !important;
        }
      `}</style>
    </div>
  );
}