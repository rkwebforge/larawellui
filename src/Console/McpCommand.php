<?php

declare(strict_types=1);

namespace LarawellUi\Console;

use Illuminate\Console\Command;
use JsonException;
use LarawellUi\Mcp\Server;

/**
 * The MCP server over stdio, for AI agents: one JSON-RPC message per line in, one per line out. Add it to the agent
 * once, run from the app's root: claude mcp add larawellui -- php artisan larawell:mcp
 */
final class McpCommand extends Command
{
    protected $signature = 'larawell:mcp';

    protected $description = 'Run the LarawellUi MCP server over stdio, for AI agents';

    public function handle(Server $server): int
    {
        // stdout carries the protocol and nothing else: a stray line of output would break the client's parser.
        $in = fopen('php://stdin', 'r');
        $out = fopen('php://stdout', 'w');
        if ($in === false || $out === false) {
            return self::FAILURE;
        }

        while (($line = fgets($in)) !== false) {
            if (trim($line) === '') {
                continue;
            }
            try {
                $message = json_decode($line, true, flags: JSON_THROW_ON_ERROR);
                $response = is_array($message)
                    ? $server->handle($message)
                    : ['jsonrpc' => '2.0', 'id' => null, 'error' => ['code' => -32600, 'message' => 'Invalid request: expected a JSON object.']];
            } catch (JsonException $e) {
                $response = ['jsonrpc' => '2.0', 'id' => null, 'error' => ['code' => -32700, 'message' => 'Parse error: '.$e->getMessage()]];
            }
            if ($response !== null) {
                fwrite($out, json_encode($response, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)."\n");
                fflush($out);
            }
        }

        return self::SUCCESS;
    }
}
