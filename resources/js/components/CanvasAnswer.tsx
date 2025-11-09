import React, { useRef, useState, useEffect } from 'react';
import { Undo, Trash2, Save, Eye, X } from 'lucide-react';

interface CanvasAnswerProps {
    sectionId: number;
    fieldKey: string;
    existingImageUrl?: string | null;
    onSave: (sectionId: number, field: string, imageFile: File) => Promise<void>;
}

interface Point {
    x: number;
    y: number;
}

interface DrawingLine {
    points: Point[];
    color: string;
    width: number;
}

const CanvasAnswer: React.FC<CanvasAnswerProps> = ({
    sectionId,
    fieldKey,
    existingImageUrl,
    onSave,
}) => {
    const canvasRef = useRef<HTMLCanvasElement>(null);
    const containerRef = useRef<HTMLDivElement>(null);
    
    const [isDrawing, setIsDrawing] = useState(false);
    const [lines, setLines] = useState<DrawingLine[]>([]);
    const [currentLine, setCurrentLine] = useState<Point[]>([]);
    const [brushSize, setBrushSize] = useState(2);
    const [color, setColor] = useState('#000000');
    const [backgroundImage, setBackgroundImage] = useState<HTMLImageElement | null>(null);
    const [showPreview, setShowPreview] = useState(false);
    const [isPanning, setIsPanning] = useState(false);
    const [lastTouchCenter, setLastTouchCenter] = useState<Point | null>(null);

    const CANVAS_WIDTH = 1200;
    const CANVAS_HEIGHT = 1600;
    const FIXED_SCALE = 3;

        // ✅ Tracking previous section/field untuk deteksi perubahan section
    const prevSectionFieldRef = useRef<string>('');
    
    // ✅ Reset canvas HANYA ketika section/field berubah (bukan saat save)
    useEffect(() => {
        const currentKey = `${sectionId}_${fieldKey}`;
        const isNewSection = prevSectionFieldRef.current !== '' && prevSectionFieldRef.current !== currentKey;
        
        // Update ref untuk next render
        prevSectionFieldRef.current = currentKey;
        
        if (isNewSection) {
            // Clear semua coretan HANYA saat pindah section
            setLines([]);
            setCurrentLine([]);
            setIsDrawing(false);
        }
        
        if (existingImageUrl) {
            const img = new Image();
            img.crossOrigin = 'anonymous';
            img.onload = () => {
                setBackgroundImage(img);
                // Jika pindah section, clear lines. Jika save, keep lines
                redrawCanvas(isNewSection ? [] : lines, img);
            };
            // ✅ Tambahkan timestamp untuk bypass cache browser
            const urlWithTimestamp = existingImageUrl.includes('?') 
                ? `${existingImageUrl}&t=${Date.now()}`
                : `${existingImageUrl}?t=${Date.now()}`;
            img.src = urlWithTimestamp;
        } else if (isNewSection) {
            // ✅ Clear background HANYA saat pindah section
            setBackgroundImage(null);
            // Clear canvas
            const canvas = canvasRef.current;
            if (canvas) {
                const ctx = canvas.getContext('2d');
                if (ctx) {
                    ctx.clearRect(0, 0, CANVAS_WIDTH, CANVAS_HEIGHT);
                    ctx.fillStyle = '#FFF9E6';
                    ctx.fillRect(0, 0, CANVAS_WIDTH, CANVAS_HEIGHT);
                    drawGrid(ctx);
                }
            }
        }
    }, [sectionId, fieldKey, existingImageUrl]);

    useEffect(() => {
        redrawCanvas(lines, backgroundImage);
    }, [lines, backgroundImage]);

    const drawGrid = (ctx: CanvasRenderingContext2D) => {
        const gridSize = 40;
        ctx.strokeStyle = '#E5D4B8';
        ctx.lineWidth = 1;

        for (let x = 0; x <= CANVAS_WIDTH; x += gridSize) {
            ctx.beginPath();
            ctx.moveTo(x, 0);
            ctx.lineTo(x, CANVAS_HEIGHT);
            ctx.stroke();
        }

        for (let y = 0; y <= CANVAS_HEIGHT; y += gridSize) {
            ctx.beginPath();
            ctx.moveTo(0, y);
            ctx.lineTo(CANVAS_WIDTH, y);
            ctx.stroke();
        }
    };

    const redrawCanvas = (linesList: DrawingLine[], bgImage: HTMLImageElement | null = null) => {
        const canvas = canvasRef.current;
        if (!canvas) return;

        const ctx = canvas.getContext('2d');
        if (!ctx) return;

        ctx.clearRect(0, 0, CANVAS_WIDTH, CANVAS_HEIGHT);
        ctx.fillStyle = '#FFF9E6';
        ctx.fillRect(0, 0, CANVAS_WIDTH, CANVAS_HEIGHT);

        drawGrid(ctx);

        if (bgImage) {
            ctx.drawImage(bgImage, 0, 0, CANVAS_WIDTH, CANVAS_HEIGHT);
        }

        linesList.forEach((line) => {
            if (line.points.length < 2) return;
            ctx.strokeStyle = line.color;
            ctx.lineWidth = line.width;
            ctx.lineCap = 'round';
            ctx.lineJoin = 'round';
            ctx.beginPath();
            ctx.moveTo(line.points[0].x, line.points[0].y);
            for (let i = 1; i < line.points.length; i++) {
                ctx.lineTo(line.points[i].x, line.points[i].y);
            }
            ctx.stroke();
        });
    };

    const getCanvasPoint = (clientX: number, clientY: number): Point => {
        const canvas = canvasRef.current;
        if (!canvas) return { x: 0, y: 0 };

        const rect = canvas.getBoundingClientRect();
        const x = (clientX - rect.left) / FIXED_SCALE;
        const y = (clientY - rect.top) / FIXED_SCALE;
        return { x, y };
    };

    const handleStart = (clientX: number, clientY: number) => {
        const point = getCanvasPoint(clientX, clientY);
        setIsDrawing(true);
        setCurrentLine([point]);
    };

    const handleMove = (clientX: number, clientY: number) => {
        if (!isDrawing) return;

        const point = getCanvasPoint(clientX, clientY);
        setCurrentLine(prev => [...prev, point]);

        const canvas = canvasRef.current;
        const ctx = canvas?.getContext('2d');
        if (!ctx || currentLine.length === 0) return;

        ctx.strokeStyle = color;
        ctx.lineWidth = brushSize;
        ctx.lineCap = 'round';
        ctx.lineJoin = 'round';

        ctx.beginPath();
        ctx.moveTo(currentLine[currentLine.length - 1].x, currentLine[currentLine.length - 1].y);
        ctx.lineTo(point.x, point.y);
        ctx.stroke();
    };

    const handleEnd = () => {
        if (isDrawing && currentLine.length > 1) {
            setLines(prev => [
                ...prev,
                {
                    points: currentLine,
                    color: color,
                    width: brushSize,
                },
            ]);
        }
        setIsDrawing(false);
        setCurrentLine([]);
    };

    // Mouse Events
    const handleMouseDown = (e: React.MouseEvent<HTMLCanvasElement>) => {
        e.preventDefault();
        handleStart(e.clientX, e.clientY);
    };

    const handleMouseMove = (e: React.MouseEvent<HTMLCanvasElement>) => {
        handleMove(e.clientX, e.clientY);
    };

    // Touch Events with 2-finger pan support
    const getTouchCenter = (touch1: React.Touch, touch2: React.Touch): Point => {
        return {
            x: (touch1.clientX + touch2.clientX) / 2,
            y: (touch1.clientY + touch2.clientY) / 2
        };
    };

    const handleTouchStart = (e: React.TouchEvent<HTMLCanvasElement>) => {
        e.preventDefault();
        
        if (e.touches.length === 2) {
            setIsPanning(true);
            setIsDrawing(false);
            setCurrentLine([]);
            const center = getTouchCenter(e.touches[0], e.touches[1]);
            setLastTouchCenter(center);
        } else if (e.touches.length === 1 && !isPanning) {
            const touch = e.touches[0];
            handleStart(touch.clientX, touch.clientY);
        }
    };

    const handleTouchMove = (e: React.TouchEvent<HTMLCanvasElement>) => {
        e.preventDefault();
        
        if (e.touches.length === 2 && isPanning) {
            const container = containerRef.current;
            if (!container || !lastTouchCenter) return;
            
            const currentCenter = getTouchCenter(e.touches[0], e.touches[1]);
            const deltaX = currentCenter.x - lastTouchCenter.x;
            const deltaY = currentCenter.y - lastTouchCenter.y;
            
            container.scrollLeft -= deltaX;
            container.scrollTop -= deltaY;
            
            setLastTouchCenter(currentCenter);
        } else if (e.touches.length === 1 && isDrawing && !isPanning) {
            const touch = e.touches[0];
            handleMove(touch.clientX, touch.clientY);
        }
    };

    const handleTouchEnd = (e: React.TouchEvent<HTMLCanvasElement>) => {
        e.preventDefault();
        
        if (e.touches.length < 2) {
            setIsPanning(false);
            setLastTouchCenter(null);
        }
        
        if (e.touches.length === 0) {
            handleEnd();
        }
    };

    const handleUndo = () => {
        if (lines.length > 0) {
            setLines(prev => prev.slice(0, -1));
        }
    };

    const handleClear = () => {
        if (window.confirm('Hapus semua gambar?')) {
            setLines([]);
            setBackgroundImage(null);
            const canvas = canvasRef.current;
            if (canvas) {
                const ctx = canvas.getContext('2d');
                if (ctx) {
                    ctx.clearRect(0, 0, CANVAS_WIDTH, CANVAS_HEIGHT);
                    ctx.fillStyle = '#FFF9E6';
                    ctx.fillRect(0, 0, CANVAS_WIDTH, CANVAS_HEIGHT);
                    drawGrid(ctx);
                }
            }
        }
    };

    const handleSave = async () => {
        const canvas = canvasRef.current;
        if (!canvas) return;

        canvas.toBlob(async (blob) => {
            if (!blob) {
                alert('Gagal menyimpan gambar');
                return;
            }
            const file = new File([blob], `answer_${sectionId}_${fieldKey}.png`, {
                type: 'image/png',
            });
            await onSave(sectionId, fieldKey, file);
        });
    };

    return (
        <div className="relative">
            {/* Toolbar */}
            <div className="mb-2 flex flex-wrap items-center justify-between gap-2 rounded-lg bg-gradient-to-r from-green-50 to-emerald-50 p-2 shadow-md border border-green-100">
                <div className="flex items-center gap-2">
                    {/* Brush Size */}
                    <div className="flex items-center gap-1 bg-white rounded-lg px-2 py-1 shadow-sm">
                        <label className="text-xs font-medium text-gray-700">Ukuran:</label>
                        <input
                            type="range"
                            min="1"
                            max="10"
                            value={brushSize}
                            onChange={(e) => setBrushSize(Number(e.target.value))}
                            className="w-16"
                        />
                        <span className="text-xs font-bold text-gray-600 w-4">{brushSize}</span>
                    </div>

                    {/* Color Picker */}
                    <input
                        type="color"
                        value={color}
                        onChange={(e) => setColor(e.target.value)}
                        className="h-8 w-12 cursor-pointer rounded border-2 border-gray-300 shadow-sm"
                    />
                </div>

                {/* Action Buttons */}
                <div className="flex gap-1">
                    <button
                        onClick={handleUndo}
                        className="rounded-lg bg-white p-2 text-gray-700 shadow hover:bg-gray-100"
                        title="Undo"
                    >
                        <Undo className="h-4 w-4" />
                    </button>
                    <button
                        onClick={handleClear}
                        className="rounded-lg bg-white p-2 text-red-600 shadow hover:bg-red-50"
                        title="Hapus Semua"
                    >
                        <Trash2 className="h-4 w-4" />
                    </button>
                    <button
                        onClick={() => setShowPreview(true)}
                        className="rounded-lg bg-blue-600 p-2 text-white shadow hover:bg-blue-700"
                        title="Preview Ukuran Asli"
                    >
                        <Eye className="h-4 w-4" />
                    </button>
                    <button
                        onClick={handleSave}
                        className="flex items-center gap-1 rounded-lg bg-green-600 px-3 py-2 text-white shadow-md hover:bg-green-700"
                    >
                        <Save className="h-4 w-4" /> <span className="text-xs font-medium">Simpan</span>
                    </button>
                </div>
            </div>

            {/* Canvas Container */}
            <div
                ref={containerRef}
                className="relative overflow-auto rounded-xl border-4 border-gray-300 bg-gray-200 shadow-lg"
                style={{
                    height: '70vh',
                    cursor: 'crosshair',
                }}
            >
                <canvas
                    ref={canvasRef}
                    width={CANVAS_WIDTH}
                    height={CANVAS_HEIGHT}
                    onMouseDown={handleMouseDown}
                    onMouseMove={handleMouseMove}
                    onMouseUp={handleEnd}
                    onMouseLeave={handleEnd}
                    onTouchStart={handleTouchStart}
                    onTouchMove={handleTouchMove}
                    onTouchEnd={handleTouchEnd}
                    style={{
                        transform: `scale(${FIXED_SCALE})`,
                        transformOrigin: '0 0',
                        touchAction: 'none',
                    }}
                />
            </div>

            {/* Tips */}
            <div className="mt-2 rounded-lg bg-blue-50 p-2 border border-blue-200">
                <p className="text-xs text-blue-800">
                   💡<strong>Mobile:</strong> 1 jari = gambar, 2 jari = geser. <strong>Desktop:</strong> Scroll untuk geser. Klik <Eye className="inline h-3 w-3" /> untuk preview ukuran asli.
                </p>
            </div>

            {/* Preview Modal */}
            {showPreview && (
                <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/80 p-4">
                    <div className="relative max-h-[90vh] max-w-[90vw] overflow-auto rounded-lg bg-white p-4">
                        <div className="mb-2 flex items-center justify-between">
                            <h3 className="text-lg font-bold text-gray-800">Preview Ukuran Asli</h3>
                            <button
                                onClick={() => setShowPreview(false)}
                                className="rounded-lg bg-red-600 p-2 text-white hover:bg-red-700"
                            >
                                <X className="h-5 w-5" />
                            </button>
                        </div>
                        <div className="overflow-auto border-2 border-gray-300 rounded">
                            <canvas
                                width={CANVAS_WIDTH}
                                height={CANVAS_HEIGHT}
                                ref={(previewCanvas) => {
                                    if (previewCanvas && canvasRef.current) {
                                        const ctx = previewCanvas.getContext('2d');
                                        if (ctx) {
                                            ctx.drawImage(canvasRef.current, 0, 0);
                                        }
                                    }
                                }}
                            />
                        </div>
                    </div>
                </div>
            )}
        </div>
    );
};

export default CanvasAnswer;