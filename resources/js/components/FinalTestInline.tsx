import React, { useEffect, useState, useRef } from "react";
import { router } from "@inertiajs/react";
import toast from "react-hot-toast";
import Swal from "sweetalert2";
import CanvasAnswer from "./CanvasAnswer";

interface FinalTestProps {
  finalTest: {
    id: number;
    title: string;
    duration: number;
    questions: {
      id: number;
      question: string;
      max_score: number;
    }[];
  };
  attempt: {
    id: number;
    student_id: number;
    material_id: number;
    started_at: string;
    expires_at: string;
    finished_at: string | null;
    is_submitted: boolean;
    answers: {
      id: number;
      question_id: number;
      answer_text?: string;
      answer_file?: string;
    }[];
  };
  onSubmitSuccess?: () => void;
}

const FinalTestInline: React.FC<FinalTestProps> = ({
  finalTest,
  attempt,
  onSubmitSuccess,
}) => {
  // ✅ State untuk jawaban dengan initial value dari attempt
  const [answers, setAnswers] = useState<Record<number, any>>(() => {
    const map: Record<number, any> = {};
    attempt.answers?.forEach((ans) => {
      map[ans.question_id] = {
        id: ans.id,
        answer_text: ans.answer_text,
        answer_file: ans.answer_file,
      };
    });
    console.log('📝 Initial answers loaded:', map);
    return map;
  });

  // ✅ Track apakah canvas sedang aktif digambar (untuk prevent update state)
  const [activeCanvases, setActiveCanvases] = useState<Set<number>>(new Set());

  const [timeLeft, setTimeLeft] = useState<number>(0);
  const [saving, setSaving] = useState(false);
  const [isSubmitted, setIsSubmitted] = useState(
    attempt.is_submitted || !!attempt.finished_at
  );

  const expiry = new Date(attempt.expires_at).getTime();
  const timerRef = useRef<NodeJS.Timeout | null>(null);

  // 🕒 Timer
  useEffect(() => {
    if (isSubmitted) {
      setTimeLeft(0);
      return;
    }

    timerRef.current = setInterval(() => {
      const now = Date.now();
      const remaining = Math.max(0, Math.floor((expiry - now) / 1000));
      setTimeLeft(remaining);

      if (remaining <= 0) {
        clearInterval(timerRef.current!);
        handleSubmitAll(true);
      }
    }, 1000);

    return () => {
      if (timerRef.current) clearInterval(timerRef.current);
    };
  }, [expiry, isSubmitted]);

  const formatTime = (seconds: number) => {
    const m = Math.floor(seconds / 60);
    const s = seconds % 60;
    return `${m}:${s.toString().padStart(2, "0")}`;
  };

  // ✅ PERBAIKAN: Update state HANYA jika canvas tidak sedang aktif
  const handleCanvasSave = async (questionId: number, field: string, imageFile: File) => {
    console.log('💾 Saving answer for question:', questionId);
    
    const formData = new FormData();
    formData.append("answer_file", imageFile);

    try {
      const response = await fetch(`/final-test/save-answer/${attempt.id}/${questionId}`, {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': (document.querySelector('meta[name="csrf-token"]') as HTMLMetaElement)?.content || '',
        },
        body: formData,
      });

      const data = await response.json();
      console.log('📥 Response from server:', data);

      if (!response.ok) {
        throw new Error(data.message || 'Gagal menyimpan jawaban');
      }

      toast.success(data.message || "✅ Jawaban canvas berhasil disimpan!");
      
      // ✅ Update state untuk persistence, tapi tandai canvas sebagai "just saved"
      if (data.answer) {
        // Tandai canvas ini sebagai "baru saja save" untuk prevent reload
        setActiveCanvases(prev => new Set(prev).add(questionId));
        
        // Update state setelah delay singkat
        setTimeout(() => {
          setAnswers((prev) => ({
            ...prev,
            [questionId]: {
              id: data.answer.id,
              answer_file: data.answer.answer_file,
              answer_text: data.answer.answer_text,
            },
          }));
          
          // Remove dari active setelah update
          setTimeout(() => {
            setActiveCanvases(prev => {
              const newSet = new Set(prev);
              newSet.delete(questionId);
              return newSet;
            });
          }, 100);
        }, 100);
      }

      return Promise.resolve();
    } catch (error: any) {
      console.error("❌ Error saving answer:", error);
      toast.error(error.message || "❌ Gagal menyimpan jawaban canvas.");
      return Promise.reject(error);
    }
  };

  const handleSubmitAll = async (auto = false) => {
    if (isSubmitted) return;

    // ⚠️ Jika bukan auto-submit (diklik manual), tampilkan peringatan
    if (!auto) {
      const result = await Swal.fire({
        title: "⚠️ Peringatan Penting!",
        html: `
          <div style="text-align: left; font-size: 15px; line-height: 1.6;">
            <p style="margin-bottom: 12px; font-weight: 600;">Pastikan setiap jawaban sudah diklik tombol <span style="color: #10b981; font-weight: 700;">"Simpan"</span>!</p>
            <p style="margin-bottom: 8px;">❌ Jawaban yang belum disimpan <strong>tidak akan terkumpul</strong>.</p>
            <p>✅ Cek kembali setiap soal dan pastikan sudah klik "Simpan".</p>
          </div>
        `,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Kumpulkan",
        cancelButtonText: "Cek Lagi",
        confirmButtonColor: "#2f6a62",
        cancelButtonColor: "#6b7280",
        reverseButtons: true,
        customClass: {
          popup: "rounded-2xl",
          confirmButton: "rounded-lg px-6 py-2.5 font-semibold",
          cancelButton: "rounded-lg px-6 py-2.5 font-semibold",
        },
      });

      // Jika klik "Cek Lagi", batalkan submit
      if (!result.isConfirmed) {
        return;
      }
    }

    if (timerRef.current) clearInterval(timerRef.current);
    setTimeLeft(0);
    setSaving(true);

    toast.success(
      auto
        ? "⏰ Waktu habis, mengirim semua jawaban..."
        : "📝 Mengirim semua jawaban..."
    );

    router.post(`/final-test/submit/${attempt.id}`, {}, {
      onSuccess: () => {
        toast.success("🎉 Tes akhir berhasil dikirim!");
        setIsSubmitted(true);
        
        // ✅ PERBAIKAN: Reload halaman untuk update state finish button
        if (onSubmitSuccess) {
          onSubmitSuccess();
        }
        
        // ✅ Reload setelah 1 detik agar toast terlihat
        setTimeout(() => {
          window.location.reload();
        }, 1000);
      },
      onError: () => toast.error("❌ Gagal mengirim tes akhir."),
      onFinish: () => setSaving(false),
    });
  };

  return (
    <div className="rounded-2xl bg-white p-8 shadow-lg">
      {/* Header */}
      <div className="mb-8 flex items-center justify-between border-b border-gray-200 pb-6">
        <div>
          <h2 className="text-2xl font-semibold text-gray-800">
            {finalTest.title}
          </h2>
          <p className="text-sm text-gray-500 mt-1">Tes Akhir</p>
        </div>
        <div>
          {isSubmitted ? (
            <div className="flex items-center gap-2 bg-green-50 px-4 py-2 rounded-lg">
              <span className="text-lg font-semibold text-green-600">Tes Selesai</span>
            </div>
          ) : (
            <div className="flex items-center gap-2 bg-red-50 px-4 py-2 rounded-lg">
              <span className="text-red-600">⏱</span>
              <span className="text-lg font-semibold text-red-600">
                {formatTime(timeLeft)}
              </span>
            </div>
          )}
        </div>
      </div>

      {/* Soal */}
      <style>{`
        .question-content ol {
          list-style-type: decimal;
          padding-left: 1.5rem;
          margin-bottom: 1rem;
        }
        .question-content ol ol {
          list-style-type: lower-alpha;
          padding-left: 1.5rem;
          margin-top: 0.5rem;
        }
        .question-content li {
          margin-bottom: 0.75rem;
          line-height: 1.75;
        }
        .question-content br {
          display: block;
          content: "";
          margin-top: 0.5rem;
        }
        .question-content img {
          max-width: 500px;
          width: 50%;
          height: auto;
          border-radius: 8px;
          border: 1px solid #e5e7eb;
          margin: 1rem 0;
          display: block;
        }
        .question-content img + em,
        .question-content img + p,
        .question-content figcaption {
          display: none;
        }
      `}</style>
      
      <div className="space-y-8">
        {finalTest.questions.map((q, idx) => {
          const existingAnswer = answers[q.id];
          const existingImageUrl = existingAnswer?.answer_file 
            ? `/storage/${existingAnswer.answer_file}` 
            : null;
          
          // ✅ Use key untuk force re-render HANYA saat data baru dari server
          const canvasKey = `canvas-${q.id}-${existingImageUrl || 'new'}`;
          
          console.log(`🖼️ Question ${q.id} - Image: ${existingImageUrl}, Key: ${canvasKey}`);
          
          return (
            <div
              key={q.id}
              className="rounded-xl border border-gray-200 p-6 bg-white"
            >
              <div className="mb-4 flex items-start gap-3">
                <span className="flex h-8 w-8 items-center justify-center rounded-full bg-teal-100 text-sm font-bold text-teal-700">
                  {idx + 1}
                </span>
                <div
                  className="question-content flex-1 text-gray-700 leading-relaxed"
                  dangerouslySetInnerHTML={{
                    __html: q.question,
                  }}
                />
              </div>

              <div className="mt-4">
                <CanvasAnswer
                  key={canvasKey}
                  sectionId={q.id}
                  fieldKey="answer"
                  existingImageUrl={existingImageUrl}
                  onSave={handleCanvasSave}
                />
              </div>
            </div>
          );
        })}
      </div>

      {/* Tombol Aksi */}
      <div className="mt-10 text-center border-t border-gray-200 pt-8">
        <button
          onClick={() => handleSubmitAll(false)}
          disabled={saving || isSubmitted || timeLeft <= 0}
          className={`rounded-xl px-8 py-3 font-semibold text-white transition-colors flex items-center gap-2 mx-auto ${
            saving || isSubmitted || timeLeft <= 0
              ? "cursor-not-allowed bg-gray-400"
              : "bg-[rgb(47,106,98)] hover:bg-green-900"
          }`}
        >
          {isSubmitted ? (
            <>
              <span>Tes Sudah Dikirim</span>
            </>
          ) : saving ? (
            <>
              <span className="animate-spin">⏳</span>
              <span>Mengirim...</span>
            </>
          ) : timeLeft <= 0 ? (
            <>
              <span>⏰</span>
              <span>Waktu Habis</span>
            </>
          ) : (
            <>
              <span>Selesaikan Tes</span>
            </>
          )}
        </button>
      </div>
    </div>
  );
};

export default FinalTestInline;