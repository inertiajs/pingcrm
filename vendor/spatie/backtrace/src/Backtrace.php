<?php

namespace Spatie\Backtrace;

use Closure;
use Throwable;

class Backtrace
{
    /** @var bool */
    protected $withArguments = false;

    /** @var bool */
    protected $withObject = false;

    /** @var string|null */
    protected $applicationPath;

    /** @var int */
    protected $offset = 0;

    /** @var int */
    protected $limit = 0;

    /** @var \Closure|null */
    protected $startingFromFrameClosure = null;

    /** @var \Throwable|null */
    protected $throwable = null;

    public static function create(): self
    {
        return new static();
    }

    public static function createForThrowable(Throwable $throwable): self
    {
        return (new static())->forThrowable($throwable);
    }

    protected function forThrowable(Throwable $throwable): self
    {
        $this->throwable = $throwable;

        return $this;
    }

    public function withArguments(): self
    {
        $this->withArguments = true;

        return $this;
    }

    public function withObject(): self
    {
        $this->withObject = true;

        return $this;
    }

    public function applicationPath(string $applicationPath): self
    {
        $this->applicationPath = $applicationPath;

        return $this;
    }

    public function offset(int $offset): self
    {
        $this->offset = $offset;

        return $this;
    }

    public function limit(int $limit): self
    {
        $this->limit = $limit;

        return $this;
    }

    public function startingFromFrame(Closure $startingFromFrameClosure)
    {
        $this->startingFromFrameClosure = $startingFromFrameClosure;

        return $this;
    }

    /**
     * @return \Spatie\Backtrace\Frame[]
     */
    public function frames(): array
    {
        $rawFrames = $this->getRawFrames();

        return $this->toFrameObjects($rawFrames);
    }

    public function firstApplicationFrameIndex(): ?int
    {
        foreach ($this->frames() as $index => $frame) {
            if ($frame->applicationFrame) {
                return $index;
            }
        }

        return null;
    }

    protected function getRawFrames(): array
    {
        if ($this->throwable) {
            return $this->throwable->getTrace();
        }

        $options = null;

        if (! $this->withArguments) {
            $options = $options | DEBUG_BACKTRACE_IGNORE_ARGS;
        }

        if ($this->withObject()) {
            $options = $options | DEBUG_BACKTRACE_PROVIDE_OBJECT;
        }

        $limit = $this->limit;

        if ($limit !== 0) {
            $limit += 3;
        }

        return debug_backtrace($options, $limit);
    }

    /**
     * @return \Spatie\Backtrace\Frame[]
     */
    protected function toFrameObjects(array $rawFrames): array
    {
        $currentFile = $this->throwable ? $this->throwable->getFile() : '';
        $currentLine = $this->throwable ? $this->throwable->getLine() : 0;

        $frames = [];

        foreach ($rawFrames as $rawFrame) {
            $frames[] = new Frame(
                $currentFile,
                $currentLine,
                $rawFrame['args'] ?? null,
                $rawFrame['function'] ?? null,
                $rawFrame['class'] ?? null,
                $this->isApplicationFrame($currentFile)
            );

            $currentFile = $rawFrame['file'] ?? 'unknown';
            $currentLine = $rawFrame['line'] ?? 0;
        }

        $frames[] = new Frame(
            $currentFile,
            $currentLine,
            [],
            '[top]'
        );

        $frames = $this->removeBacktracePackageFrames($frames);

        if ($closure = $this->startingFromFrameClosure) {
            $frames = $this->startAtFrameFromClosure($frames, $closure);
        }
        $frames = array_slice($frames, $this->offset, $this->limit === 0 ? PHP_INT_MAX : $this->limit);

        return array_values($frames);
    }

    protected function isApplicationFrame(string $frameFilename): bool
    {
        $relativeFile = str_replace('\\', DIRECTORY_SEPARATOR, $frameFilename);

        if (! empty($this->applicationPath)) {
            $relativeFile = array_reverse(explode($this->applicationPath ?? '', $frameFilename, 2))[0];
        }

        if (strpos($relativeFile, DIRECTORY_SEPARATOR . 'vendor') === 0) {
            return false;
        }

        return true;
    }

    protected function removeBacktracePackageFrames(array $frames): array
    {
        return $this->startAtFrameFromClosure($frames, function (Frame $frame) {
            return $frame->class !== static::class;
        });
    }

    /**
     * @param \Spatie\Backtrace\Frame[] $frames
     * @param \Closure $closure
     *
     * @return array
     */
    protected function startAtFrameFromClosure(array $frames, Closure $closure): array
    {
        foreach ($frames as $i => $frame) {
            $foundStartingFrame = $closure($frame);

            if ($foundStartingFrame) {
                return $frames;
            }

            unset($frames[$i]);
        }

        return $frames;
    }
}
