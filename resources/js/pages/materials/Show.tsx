import React, { useState } from "react";
import { useForm } from "@inertiajs/react";

interface Material {
  id: number;
  title: string;
  content: string;
}

interface Topic {
  id: number;
  title: string;
  description?: string;
}

interface Props {
  topic: Topic;
  materials: Material[];
  level: number | null;
  errors?: Record<string, string>;
}

declare function route(name: string, params?: any): string;


export default function Show({ topic, materials, level, errors }: Props) {
  const [showInput, setShowInput] = useState(false);
  const { data, setData, post, processing } = useForm({ code: "" });

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    post(route("materials.verify", topic.id));
  };

  return (
    <div className="min-h-screen bg-[#f8faf9] py-10 px-4">
      <div className="max-w-5xl mx-auto bg-white shadow rounded-2xl p-8">
        <h1 className="text-2xl font-bold text-gray-900 mb-3 text-center">
          {topic.title}
        </h1>
        {topic.description && (
          <p className="text-gray-600 text-center mb-8">{topic.description}</p>
        )}

        {!level && materials.length === 0 ? (
          <div className="text-center space-y-6">
            <p className="text-gray-600">
              Mainkan game berikut untuk mendapatkan kode akses sesuai levelmu.
            </p>

            <a
              href="https://yourgameurl.com"
              target="_blank"
              rel="noopener noreferrer"
              className="inline-block bg-[#2f6a62] text-white px-6 py-3 rounded-lg font-medium hover:bg-[#24564e] transition-colors"
            >
              🎮 Play Game
            </a>

            {!showInput ? (
              <button
                onClick={() => setShowInput(true)}
                className="block mx-auto text-sm text-[#2f6a62] underline mt-4"
              >
                Sudah punya kode akses?
              </button>
            ) : (
              <form
                onSubmit={handleSubmit}
                className="mt-6 max-w-sm mx-auto space-y-4"
              >
                <input
                  type="text"
                  value={data.code}
                  onChange={(e) => setData("code", e.target.value)}
                  placeholder="Masukkan kode akses..."
                  className="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#2f6a62] focus:outline-none"
                />
                {errors?.code && (
                  <p className="text-red-500 text-sm">{errors.code}</p>
                )}
                <button
                  type="submit"
                  disabled={processing}
                  className="w-full bg-[#2f6a62] text-white py-2 rounded-lg hover:bg-[#24564e] transition-colors"
                >
                  {processing ? "Memeriksa..." : "Verifikasi Kode"}
                </button>
              </form>
            )}
          </div>
        ) : (
          <div>
            <h2 className="text-lg font-semibold text-[#2f6a62] mb-4">
              Materi untuk Level {level}
            </h2>
            <div className="grid md:grid-cols-2 gap-6">
              {materials.map((m) => (
                <div
                  key={m.id}
                  className="p-5 border rounded-lg hover:shadow-md transition"
                >
                  <h3 className="font-bold text-gray-800">{m.title}</h3>
                  <p className="text-gray-600 text-sm mt-2 line-clamp-3">
                    {m.content}
                  </p>
                </div>
              ))}
            </div>
          </div>
        )}
      </div>
    </div>
  );
}
