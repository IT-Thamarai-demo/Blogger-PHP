<?php

/**
 * @OA\Info(title="Blog API", version="1.0.0")
 */

/**
 * @OA\Get(
 *     path="/generate-random-title",
 *     summary="Generate a random blog title",
 *     @OA\Response(response="200", description="Successfully generated random title"),
 *     @OA\Response(response="405", description="Method Not Allowed"),
 * )
 */

/**
 * @OA\Get(
 *     path="/generate-random-content",
 *     summary="Generate random blog content",
 *     @OA\Response(response="200", description="Successfully generated random content"),
 *     @OA\Response(response="405", description="Method Not Allowed"),
 * )
 */
