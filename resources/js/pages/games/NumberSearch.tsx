import React, { useEffect, useState } from 'react';
import './NumberSearch.css';

interface Pattern {
    id: number;
    name: string;
    cells: number[][];
    color: string;
}

interface NumberSearchGameProps {
    onCodeCreated?: (code: string, level: string) => void;
}

const gridData: (number | null)[][] = [
    [2, 6, 17, 19, 25, 42, 16],
    [30, 4, 13, 14, 35, 31, 24],
    [35, 19, 8, 28, 10, 22, 32],
    [40, 13, 21, 16, 29, 34, 40],
    [45, 14, 5, 17, 32, 23, 48],
    [7, 11, 9, 12, 15, 18, 26],
    [4, 8, 12, 16, 20, 33, 27],
];

const patterns: Pattern[] = [
    {
        id: 0,
        name: 'Diagonal Merah 1',
        cells: [
            [0, 0],
            [1, 1],
            [2, 2],
            [3, 3],
            [4, 4],
        ],
        color: 'red',
    },
    {
        id: 1,
        name: 'Horizontal Merah',
        cells: [
            [6, 0],
            [6, 1],
            [6, 2],
            [6, 3],
            [6, 4],
        ],
        color: 'red',
    },
    {
        id: 2,
        name: 'Vertikal Hijau',
        cells: [
            [0, 6],
            [1, 6],
            [2, 6],
            [3, 6],
            [4, 6],
        ],
        color: 'green',
    },
    {
        id: 3,
        name: 'Vertikal Ungu',
        cells: [
            [1, 0],
            [2, 0],
            [3, 0],
            [4, 0],
        ],
        color: 'purple',
    },
    {
        id: 4,
        name: 'Horizontal Biru',
        cells: [
            [5, 2],
            [5, 3],
            [5, 4],
            [5, 5],
        ],
        color: 'blue',
    },
    {
        id: 5,
        name: 'Diagonal Orange',
        cells: [
            [5, 0],
            [4, 1],
            [3, 2],
            [2, 3],
            [1, 4],
        ],
        color: 'orange',
    },
];

function generateRandomCode(prefix: string): string {
    const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    let code = prefix;
    for (let i = 0; i < 4; i++) {
        code += chars[Math.floor(Math.random() * chars.length)];
    }
    return code;
}

const NumberSearchGame: React.FC<NumberSearchGameProps> = ({
    onCodeCreated,
}) => {
    const [selectedCells, setSelectedCells] = useState<string[]>([]);
    const [foundPatterns, setFoundPatterns] = useState<number[]>([]);
    const [timeRemaining, setTimeRemaining] = useState(300);
    const [gameActive, setGameActive] = useState(true);
    const [showModal, setShowModal] = useState(false);

    const [finalCode, setFinalCode] = useState<string>('');
    const [finalLevel, setFinalLevel] = useState<string>('');
    const [emoji, setEmoji] = useState('😊');
    const [title, setTitle] = useState('Selesai!');

    const cellKey = (r: number, c: number) => `${r},${c}`;

    // Timer
    useEffect(() => {
        if (!gameActive) return;
        const interval = setInterval(() => {
            setTimeRemaining((t) => {
                if (t <= 1) {
                    setGameActive(false);
                    setShowModal(true);
                    return 0;
                }
                return t - 1;
            });
        }, 1000);
        return () => clearInterval(interval);
    }, [gameActive]);

    const formatTime = (sec: number) => {
        const m = Math.floor(sec / 60);
        const s = sec % 60;
        return `${m}:${s.toString().padStart(2, '0')}`;
    };

    // Handle select cell
    const handleCellClick = (r: number, c: number) => {
        if (!gameActive) return;
        const key = cellKey(r, c);

        setSelectedCells((prev) =>
            prev.includes(key) ? prev.filter((k) => k !== key) : [...prev, key],
        );
    };

    // Check Patterns
    useEffect(() => {
        for (let p of patterns) {
            if (foundPatterns.includes(p.id)) continue;

            const patternKeys = p.cells.map(([r, c]) => cellKey(r, c));
            const same =
                selectedCells.length === patternKeys.length &&
                [...selectedCells]
                    .sort()
                    .every((v, i) => v === patternKeys.sort()[i]);

            if (same) {
                setFoundPatterns((prev) => [...prev, p.id]);
                setSelectedCells([]);

                if (foundPatterns.length + 1 === patterns.length) {
                    setTimeout(() => {
                        setGameActive(false);
                        setShowModal(true);
                    }, 300);
                }
                break;
            }
        }
    }, [selectedCells]);

    const getMatchClass = (r: number, c: number) => {
        for (let p of patterns) {
            if (!foundPatterns.includes(p.id)) continue;
            if (p.cells.some(([rr, cc]) => rr === r && cc === c)) {
                return `found matched-${p.color}`;
            }
        }
        return '';
    };

    const foundCount = foundPatterns.length;


    useEffect(() => {
        if (!gameActive && showModal && !finalCode) {
            let newLevel = 'Inferior';
            let newCode = generateRandomCode('IF');
            let newEmoji = '😊';
            let newTitle = 'Selesai!';

            if (foundPatterns.length >= 3 && foundPatterns.length <= 5) {
                newLevel = 'Reguler';
                newCode = generateRandomCode('RG');
                newEmoji = '👍';
                newTitle = 'Bagus!';
            }
            if (foundPatterns.length === 6) {
                newLevel = 'Superior';
                newCode = generateRandomCode('SP');
                newEmoji = '🎉';
                newTitle = 'Luar Biasa!';
            }

            setFinalLevel(newLevel);
            setFinalCode(newCode);
            setEmoji(newEmoji);
            setTitle(newTitle);

            console.log('Kode dibuat karena waktu habis:', newCode, newLevel);
        }
    }, [gameActive, showModal]);
    
    useEffect(() => {
        if (showModal && finalCode && finalLevel && onCodeCreated) {
            onCodeCreated(finalCode, finalLevel.toLowerCase());
        }
    }, [finalCode, finalLevel, showModal]);

    return (
        <div
            className="flex flex-col items-center justify-center p-6"
            style={{ backgroundColor: 'rgb(224,234,232)' }}
        >
            <h1
                className="mb-3 text-center text-4xl font-bold"
                style={{ color: 'rgb(47,106,98)' }}
            >
                Number Search Game
            </h1>

            <p className="mb-4 text-center text-sm text-gray-700">
                Temukan pola angka tersembunyi! Klik kotak untuk memilih.
            </p>

            <div className="mb-4 rounded-lg bg-white p-3 shadow">
                <p className="font-semibold text-gray-900">
                    📊 Ditemukan: {foundCount}/6 | ⏱ Waktu:{' '}
                    <span className="text-blue-600">
                        {formatTime(timeRemaining)}
                    </span>
                </p>
            </div>

            {/* GRID */}
            <div className="overflow-hidden rounded-lg border-4 border-gray-400">
                {gridData.map((row, r) => (
                    <div key={r} className="flex">
                        {row.map((val, c) => (
                            <div
                                key={c}
                                className={`cell flex h-14 w-14 items-center justify-center border-2 border-gray-300 text-base font-bold text-gray-800 sm:text-lg ${val === null ? 'empty' : 'cursor-pointer bg-white'} ${selectedCells.includes(cellKey(r, c)) ? 'selected' : ''} ${getMatchClass(r, c)} `}
                                onClick={() =>
                                    val !== null && handleCellClick(r, c)
                                }
                            >
                                {val}
                            </div>
                        ))}
                    </div>
                ))}
            </div>

            {/* MODAL */}
            {showModal && (
                <div className="bg-opacity-50 fixed inset-0 z-50 flex items-center justify-center bg-black">
                    <div className="w-80 rounded-2xl bg-white p-6 text-center shadow">
                        <div className="mb-3 text-6xl">{emoji}</div>
                        <h2 className="mb-2 text-2xl font-bold text-gray-800">
                            {title}
                        </h2>
                        <p className="mb-1 text-gray-800">
                            Pola ditemukan: <strong>{foundCount}</strong>/6
                        </p>
                        <p className="mb-4 font-semibold text-indigo-700">
                            Level {finalLevel}
                        </p>

                        <div className="mb-4 rounded-lg border border-yellow-400 bg-yellow-50 p-3">
                            <p className="mb-1 text-sm text-gray-600">
                                Kode Akses
                            </p>
                            <p className="mb-1 text-3xl font-bold text-indigo-800">
                                {finalCode}
                            </p>
                            <p className="text-xs text-gray-600">
                                Catat agar tidak lupa!
                            </p>
                        </div>

                        <button
                            className="rounded bg-indigo-600 px-6 py-2 text-white hover:bg-indigo-700"
                            onClick={() => setShowModal(false)}
                        >
                            Tutup
                        </button>
                    </div>
                </div>
            )}
        </div>
    );
};

export default NumberSearchGame;
