import Navigation from '@/components/navigation';
import { Head, usePage } from '@inertiajs/react';

type Option = {
    id: string;
    text: string;
    is_correct?: boolean;
};

type Question = {
    id: string;
    question_number?: number;
    text: string;
    options: Option[];
};

type Answer = {
    question_id: string;
    selected_option_id: string;
};

type ResultData = {
    score: number;
    submitted_at: string;
    correct_count: number;
    wrong_count: number;
    total_questions: number;
    questions: Question[];
    answers: Answer[];
};

interface PageProps {
    result: ResultData;
}

export default function Result() {
    const { result } = usePage<PageProps>().props;

    const getOptionLabel = (index: number): string => {
        return String.fromCharCode(65 + index);
    };

    const getUserAnswer = (questionId: string) => {
        return result.answers.find(a => a.question_id === questionId);
    };

    const getCorrectOption = (question: Question) => {
        return question.options.find(opt => opt.is_correct);
    };

    const isCorrect = (questionId: string) => {
        const userAnswer = getUserAnswer(questionId);
        if (!userAnswer) return false;
        
        const question = result.questions.find(q => q.id === questionId);
        if (!question) return false;
        
        const selectedOption = question.options.find(opt => opt.id === userAnswer.selected_option_id);
        return selectedOption?.is_correct || false;
    };

    return (
        <>
            <Head title="Hasil TKA" />
            <Navigation />
            
            <main className="min-h-screen bg-gradient-to-br from-[#e0eae8] to-[#f8faf9] px-4 py-10">
                <div className="mx-auto max-w-[1000px]">
                    {/* Score Card */}
                    <div className="mb-8 overflow-hidden rounded-2xl bg-white shadow-lg">
                        <div className="bg-gradient-to-r from-[#2f6a62] to-[#3d8278] p-8 text-white">
                            <h1 className="mb-2 text-center text-3xl font-bold">Hasil TKA</h1>
                            <div className="mx-auto mb-3 h-1 w-24 bg-white/30"></div>
                        </div>
                        
                        <div className="p-8">
                            <div className="mb-6 text-center">
                                <div className="mb-4 text-7xl font-bold text-[#2f6a62]">
                                    {Math.round(result.score)}
                                </div>
                                <p className="text-gray-600">
                                    Dikerjakan pada: {new Date(result.submitted_at).toLocaleString('id-ID')}
                                </p>
                            </div>

                            <div className="grid grid-cols-3 gap-4 mb-6">
                                <div className="rounded-lg bg-green-50 p-4 text-center">
                                    <div className="text-3xl font-bold text-green-600">
                                        {result.correct_count}
                                    </div>
                                    <div className="text-sm text-gray-600">Benar</div>
                                </div>
                                <div className="rounded-lg bg-red-50 p-4 text-center">
                                    <div className="text-3xl font-bold text-red-600">
                                        {result.wrong_count}
                                    </div>
                                    <div className="text-sm text-gray-600">Salah</div>
                                </div>
                                <div className="rounded-lg bg-blue-50 p-4 text-center">
                                    <div className="text-3xl font-bold text-blue-600">
                                        {result.total_questions}
                                    </div>
                                    <div className="text-sm text-gray-600">Total</div>
                                </div>
                            </div>

                            <a
                                href="/"
                                className="flex w-full items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-[#2f6a62] to-[#3d8278] px-6 py-3 font-semibold text-white transition-all hover:from-[#254d47] hover:to-[#2f6a62]"
                            >
                                Kembali ke Dashboard
                            </a>
                        </div>
                    </div>

                    {/* Pembahasan */}
                    <div className="mb-8">
                        <h2 className="mb-6 text-2xl font-bold text-gray-900">
                            Pembahasan Soal
                        </h2>

                        <div className="space-y-6">
                            {result.questions.map((question, index) => {
                                const userAnswer = getUserAnswer(question.id);
                                const correctOption = getCorrectOption(question);
                                const correct = isCorrect(question.id);

                                return (
                                    <div
                                        key={question.id}
                                        className={`rounded-xl border-2 bg-white p-6 shadow-md ${
                                            correct
                                                ? 'border-green-300 bg-green-50/30'
                                                : 'border-red-300 bg-red-50/30'
                                        }`}
                                    >
                                        {/* Question Header */}
                                        <div className="mb-5 flex items-start gap-4">
                                            <span
                                                className={`flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full text-sm font-bold text-white shadow-lg ${
                                                    correct
                                                        ? 'bg-gradient-to-br from-green-500 to-green-600'
                                                        : 'bg-gradient-to-br from-red-500 to-red-600'
                                                }`}
                                            >
                                                {question.question_number ?? index + 1}
                                            </span>
                                            <div className="flex-1">
                                                <p className="mb-2 font-medium leading-relaxed text-gray-900">
                                                    {question.text}
                                                </p>
                                                <div
                                                    className={`inline-flex items-center gap-2 rounded-full px-3 py-1 text-sm font-semibold ${
                                                        correct
                                                            ? 'bg-green-100 text-green-700'
                                                            : 'bg-red-100 text-red-700'
                                                    }`}
                                                >
                                                    {correct ? (
                                                        <>
                                                            <svg className="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fillRule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clipRule="evenodd" />
                                                            </svg>
                                                            Jawaban Benar
                                                        </>
                                                    ) : (
                                                        <>
                                                            <svg className="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fillRule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clipRule="evenodd" />
                                                            </svg>
                                                            Jawaban Salah
                                                        </>
                                                    )}
                                                </div>
                                            </div>
                                        </div>

                                        {/* Options */}
                                        <div className="ml-14 space-y-3">
                                            {question.options.map((option, i) => {
                                                const isUserAnswer = userAnswer?.selected_option_id === option.id;
                                                const isCorrectAnswer = option.is_correct;

                                                let optionStyle = 'border-gray-200 bg-white text-gray-700';
                                                
                                                if (isCorrectAnswer) {
                                                    optionStyle = 'border-green-500 bg-green-50 text-green-900';
                                                } else if (isUserAnswer && !isCorrectAnswer) {
                                                    optionStyle = 'border-red-500 bg-red-50 text-red-900';
                                                }

                                                return (
                                                    <div
                                                        key={option.id}
                                                        className={`flex items-start gap-3 rounded-lg border-2 p-4 ${optionStyle}`}
                                                    >
                                                        <span
                                                            className={`flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-full text-sm font-bold ${
                                                                isCorrectAnswer
                                                                    ? 'bg-green-500 text-white'
                                                                    : isUserAnswer
                                                                    ? 'bg-red-500 text-white'
                                                                    : 'bg-gray-200 text-gray-700'
                                                            }`}
                                                        >
                                                            {getOptionLabel(i)}
                                                        </span>
                                                        <div className="flex-1">
                                                            <span>{option.text}</span>
                                                            {isCorrectAnswer && (
                                                                <span className="ml-2 text-xs font-semibold text-green-600">
                                                                    ✓ Jawaban Benar
                                                                </span>
                                                            )}
                                                            {isUserAnswer && !isCorrectAnswer && (
                                                                <span className="ml-2 text-xs font-semibold text-red-600">
                                                                    ✗ Jawaban Anda
                                                                </span>
                                                            )}
                                                        </div>
                                                    </div>
                                                );
                                            })}
                                        </div>
                                    </div>
                                );
                            })}
                        </div>
                    </div>
                </div>
            </main>
        </>
    );
}