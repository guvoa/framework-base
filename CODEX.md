# Codex Project Rules – framework-base

## Contexto
Este proyecto es un framework base en PHP orientado a aplicaciones web
modulares, con enfoque en claridad, mantenibilidad y crecimiento ordenado.

## Reglas generales
- Respetar la estructura existente del proyecto
- NO eliminar archivos sin indicación explícita
- NO mover carpetas arbitrariamente
- Priorizar código claro sobre soluciones “ingeniosas”
- Todo código debe ser compatible con PHP 8.x

## Arquitectura
- app/        → lógica de negocio
- public/     → punto de entrada y assets
- config/     → configuración
- storage/    → logs y archivos temporales

## Estilo
- Código legible y comentado cuando sea necesario
- Nombres descriptivos en inglés o español (consistentes)
- Evitar acoplamiento innecesario

## Flujo de trabajo
- Analizar antes de modificar
- Proponer cambios antes de aplicarlos si el impacto es alto
