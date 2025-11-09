import { useState } from "react";
import axios from "axios";
import toast from "react-hot-toast";

export default function InputCodePage() {
  const [code, setCode] = useState("");
  const [loading, setLoading] = useState(false);
  const [materials, setMaterials] = useState<any[]>([]);

  const handleVerify = async () => {
    setLoading(true);
    try {
      const res = await axios.post("/api/verify-code", { code });
      toast.success("Kode valid! Materi berhasil dibuka 🎉");
      setMaterials(res.data.subtopic.materials);
    } catch (err: any) {
      toast.error(err.response?.data?.error || "Kode tidak valid.");
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="p-8">
      <h2 className="text-2xl font-bold mb-4">Masukkan Kode Game</h2>
      <input
        type="text"
        value={code}
        onChange={(e) => setCode(e.target.value)}
        placeholder="Contoh: ABC123"
        className="border p-2 rounded w-64"
      />
      <button
        onClick={handleVerify}
        disabled={loading}
        className="ml-2 bg-green-600 text-white px-4 py-2 rounded"
      >
        {loading ? "Memeriksa..." : "Verifikasi"}
      </button>

      <div className="mt-6">
        {materials.length > 0 && (
          <>
            <h3 className="text-xl font-semibold mb-2">Materi Tersedia:</h3>
            <ul className="list-disc pl-6">
              {materials.map((m) => (
                <li key={m.id}>{m.title}</li>
              ))}
            </ul>
          </>
        )}
      </div>
    </div>
  );
}
